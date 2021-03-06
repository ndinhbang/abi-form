<?php

namespace App\Forms\Concerns;

use Closure;
use App\Forms\Components\Component;
use App\Forms\Components\Field;

trait HasComponents
{
    /**
     * @var mixed[]|\Closure
     */
    protected $components = [];

    /**
     * @param mixed[]|\Closure $components
     * @return $this
     */
    public function components($components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * @param mixed[]|\Closure $components
     * @return $this
     */
    public function schema($components)
    {
        $this->components($components);

        return $this;
    }

    /**
     * @param \Closure|string $callback
     */
    public function getComponent($callback, bool $withHidden = false): ?Component
    {
        $callback = $callback instanceof Closure
             ? $callback
             : function (Component $component) use ($callback) : bool {
                 return $component instanceof Field && $component->getStatePath() === $callback;
             };

        return collect($this->getFlatComponents($withHidden))->first($callback);
    }

    public function getFlatComponents(bool $withHidden = false): array
    {
        return collect($this->getComponents($withHidden))
            ->map(function (Component $component) use ($withHidden) {
                if ($component->hasChildComponentContainer()) {
                    return array_merge([$component], $component->getChildComponentContainer()->getFlatComponents($withHidden));
                }

                return $component;
            })
            ->flatten()
            ->all();
    }

    public function getFlatFields(bool $withHidden = false): array
    {
        return collect($this->getFlatComponents($withHidden))
            ->whereInstanceOf(Field::class)
            ->mapWithKeys(function (Field $field) {
                return [
                    $field->getName() => $field,
                ];
            })
            ->all();
    }

    public function getComponents(bool $withHidden = false): array
    {
        $components = array_map(function (Component $component): Component {
            $component->container($this);

            return $component;
        }, $this->evaluate($this->components));

        if ($withHidden) {
            return $components;
        }

        return array_filter(
            $components,
            function (Component $component) {
                return ! $component->isHidden();
            }
        );
    }
}
