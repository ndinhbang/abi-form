<?php

namespace App\Forms\Components\Concerns;

trait Cloneable
{
    /**
     * @return $this
     */
    public function getClone()
    {
        return clone $this;
    }
}
