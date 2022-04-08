<?php

namespace App\Forms\Concerns;

use Closure;

trait HasFieldWrapper
{
    /**
     * @var string|\Closure|null
     */
    protected $fieldWrapperView = null;

    /**
     * @param  string|\Closure|null  $view
     * @return $this
     */
    public function fieldWrapperView($view)
    {
        $this->fieldWrapperView = $view;

        return $this;
    }

    public function getCustomFieldWrapperView(): ?string
    {
        return $this->evaluate($this->fieldWrapperView) ??
            optional($this->getParentComponent())->getCustomFieldWrapperView();
    }
}
