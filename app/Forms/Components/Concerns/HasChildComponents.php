<?php

namespace App\Forms\Components\Concerns;

use Closure;
use App\Forms\ComponentContainer;

trait HasChildComponents
{
    /**
     * @var mixed[]|\Closure
     */
    protected $childComponents = [];

    /**
     * @param mixed[]|\Closure $components
     * @return $this
     */
    public function childComponents($components)
    {
        $this->childComponents = $components;

        return $this;
    }

    /**
     * @param mixed[]|\Closure $components
     * @return $this
     */
    public function schema($components)
    {
        $this->childComponents($components);

        return $this;
    }

    public function getChildComponents(): array
    {
        return $this->evaluate($this->childComponents);
    }

    public function getChildComponentContainer(): ComponentContainer
    {
        return ComponentContainer::make()
            ->parentComponent($this)
            ->components($this->getChildComponents());
    }

    public function getChildComponentContainers(bool $withHidden = false): array
    {
        if (! $this->hasChildComponentContainer($withHidden)) {
            return [];
        }

        return [$this->getChildComponentContainer()];
    }

    public function hasChildComponentContainer(bool $withHidden = false): bool
    {
        if ((! $withHidden) && $this->isHidden()) {
            return false;
        }

        if ($this->getChildComponents() === []) {
            return false;
        }

        return true;
    }
}
