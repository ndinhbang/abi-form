<?php

namespace App\Forms\Components\Concerns;

use Closure;

trait HasInlineLabel
{
    /**
     * @var \Closure|bool|null
     */
    protected $hasInlineLabel = null;

    /**
     * @param \Closure|bool|null $condition
     * @return $this
     */
    public function inlineLabel($condition = true)
    {
        $this->hasInlineLabel = $condition;

        return $this;
    }

    public function hasInlineLabel(): ?bool
    {
        return $this->evaluate($this->hasInlineLabel) ?? $this->getContainer()->hasInlineLabel();
    }
}
