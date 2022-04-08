<?php

namespace App\Forms\Concerns;

trait CanBeHidden
{
    public function isHidden(): bool
    {
        return (bool) optional($this->getParentComponent())->isHidden();
    }
}
