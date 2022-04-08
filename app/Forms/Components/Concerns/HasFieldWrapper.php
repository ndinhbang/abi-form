<?php

namespace App\Forms\Components\Concerns;

use Closure;

trait HasFieldWrapper
{
    /**
     * @var string|\Closure|null
     */
    protected $fieldWrapperView = null;

    /**
     * @param string|\Closure|null $view
     * @return $this
     */
    public function fieldWrapperView($view)
    {
        $this->fieldWrapperView = $view;

        return $this;
    }

    public function getFieldWrapperView(): string
    {
        if ($this->hasInlineLabel()) {
            return 'forms::field-wrapper.inline';
        }

        return $this->getCustomFieldWrapperView() ??
            $this->getContainer()->getCustomFieldWrapperView() ??
            'forms::field-wrapper';
    }

    public function getCustomFieldWrapperView(): ?string
    {
        return $this->evaluate($this->fieldWrapperView);
    }
}
