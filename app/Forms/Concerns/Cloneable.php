<?php

namespace App\Forms\Concerns;

trait Cloneable
{
    /**
     * @return $this
     */
    public function cloneComponents()
    {
        $components = [];

        foreach ($this->getComponents(true) as $component) {
            $components[] = $component->getClone();
        }

        return $this->components($components);
    }

    /**
     * @return $this
     */
    public function getClone()
    {
        $clone = clone $this;
        $clone->cloneComponents();

        return $clone;
    }
}
