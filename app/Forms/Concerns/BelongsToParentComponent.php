<?php

namespace App\Forms\Concerns;

use App\Forms\Components\Component;

trait BelongsToParentComponent
{
    /**
     * @var \App\Forms\Components\Component|null
     */
    protected $parentComponent;

    /**
     * @return $this
     */
    public function parentComponent(Component $component)
    {
        $this->parentComponent = $component;

        return $this;
    }

    public function getParentComponent(): ?Component
    {
        return $this->parentComponent;
    }
}
