<?php

namespace App\Forms\Concerns;

use Illuminate\Support\Arr;

trait HasState
{
    /**
     * @var string|null
     */
    protected $statePath;

    public function callAfterStateHydrated(): void
    {
        foreach ($this->getComponents(true) as $component) {
            $component->callAfterStateHydrated();

            foreach ($component->getChildComponentContainers(true) as $container) {
                $container->callAfterStateHydrated();
            }
        }
    }

    public function callAfterStateUpdated(string $path): bool
    {
        foreach ($this->getComponents(true) as $component) {
            if ($component->getStatePath() === $path) {
                $component->callAfterStateUpdated();

                return true;
            }

            foreach ($component->getChildComponentContainers() as $container) {
                if ($container->callAfterStateUpdated($path)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function callBeforeStateDehydrated(): void
    {
        foreach ($this->getComponents(true) as $component) {
            if ($component->isHidden()) {
                continue;
            }

            $component->callBeforeStateDehydrated();

            if (optional($component->getRecord())->exists) {
                $component->saveRelationships();
            }

            foreach ($component->getChildComponentContainers() as $container) {
                if ($container->isHidden()) {
                    continue;
                }

                $container->callBeforeStateDehydrated();
            }
        }
    }

    public function dehydrateState(array &$state = []): array
    {
        $this->callBeforeStateDehydrated();

        foreach ($this->getComponents() as $component) {
            if ($component->isHidden()) {
                continue;
            }

            $componentStatePath = $component->getStatePath();

            if ($component->isDehydrated()) {
                if ($component->getStatePath(false)) {
                    data_set($state, $componentStatePath, $component->dehydrateState());
                }

                foreach ($component->getChildComponentContainers() as $container) {
                    if ($container->isHidden()) {
                        continue;
                    }

                    $container->dehydrateState($state);
                }
            } else {
                Arr::forget($state, $componentStatePath);
            }
        }

        return $state;
    }

    public function mutateDehydratedState(array &$state = []): array
    {
        foreach ($this->getComponents() as $component) {
            if ($component->isHidden()) {
                continue;
            }

            if (! $component->isDehydrated()) {
                continue;
            }

            foreach ($component->getChildComponentContainers() as $container) {
                if ($container->isHidden()) {
                    continue;
                }

                $container->mutateDehydratedState($state);
            }

            if ($component->getStatePath(false)) {
                if (! $component->mutatesDehydratedState()) {
                    continue;
                }

                $componentStatePath = $component->getStatePath();

                data_set(
                    $state,
                    $componentStatePath,
                    $component->mutateDehydratedState(
                        data_get($state, $componentStatePath)
                    )
                );
            }
        }

        return $state;
    }

    /**
     * @return $this
     */
    public function fill(?array $state = null)
    {
        if ($state !== null) {
            // todo:
            $livewire = $this->getLivewire();

            if ($statePath = $this->getStatePath()) {
                data_set($livewire, $statePath, $state);
            } else {
                foreach ($state as $key => $value) {
                    data_set($livewire, $key, $value);
                }
            }

            $this->fillMissingComponentStateWithNull();

            $this->callAfterStateHydrated();
        } else {
            $this->hydrateDefaultState();
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function hydrateDefaultState()
    {
        foreach ($this->getComponents(true) as $component) {
            $component->hydrateDefaultState();
            $component->callAfterStateHydrated();

            foreach ($component->getChildComponentContainers(true) as $container) {
                $container->hydrateDefaultState();
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function fillMissingComponentStateWithNull()
    {
        foreach ($this->getComponents(true) as $component) {
            if ($component->hasChildComponentContainer()) {
                foreach ($component->getChildComponentContainers() as $container) {
                    $container->fillMissingComponentStateWithNull();
                }
            } else {
                $component->fillMissingStateWithNull();
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function statePath(?string $path)
    {
        $this->statePath = $path;

        return $this;
    }

    public function getState(): array
    {
        $state = $this->validate();

        $this->dehydrateState($state);
        $this->mutateDehydratedState($state);

        if ($statePath = $this->getStatePath()) {
            return data_get($state, $statePath, []);
        }

        return $state;
    }

    public function getStateOnly(array $keys): array
    {
        return Arr::only($this->getState(), $keys);
    }

    public function getStateExcept(array $keys): array
    {
        return Arr::except($this->getState(), $keys);
    }

    public function getStatePath(bool $isAbsolute = true): string
    {
        $pathComponents = [];

        if ($isAbsolute && $parentComponentStatePath = optional($this->getParentComponent())->getStatePath()) {
            $pathComponents[] = $parentComponentStatePath;
        }

        if (($statePath = $this->statePath) !== null) {
            $pathComponents[] = $statePath;
        }

        return implode('.', $pathComponents);
    }
}
