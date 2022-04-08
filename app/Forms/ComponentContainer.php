<?php

namespace App\Forms;

use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use Illuminate\View\Component as ViewComponent;

class ComponentContainer extends ViewComponent implements Htmlable
{
//    use Concerns\BelongsToLivewire;
    use Concerns\BelongsToModel;
    use Concerns\BelongsToParentComponent;
    use Concerns\CanBeDisabled;
    use Concerns\CanBeHidden;
    use Concerns\CanBeValidated;
    use Concerns\Cloneable;
    use Concerns\EvaluatesClosures;
    use Concerns\HasColumns;
    use Concerns\HasComponents;
    use Concerns\HasFieldWrapper;
//    use Concerns\HasInlineLabels;
    use Concerns\HasState;
//    use Concerns\HasStateBindingModifiers;
    use Concerns\ListensToEvents;
//    use Concerns\SupportsComponentFileAttachments;
//    use Concerns\SupportsFileUploadFields;
//    use Concerns\SupportsMultiSelectFields;
//    use Concerns\SupportsSelectFields;
    use Macroable;
    use Tappable;

    /**
     * @var mixed[]
     */
    protected $meta = [];

    /**
     * @return \App\Forms\ComponentContainer
     */
    public static function make(): ComponentContainer
    {
        return app(static::class);
    }

    public function render(): View
    {
        return view('base.forms.component-container', array_merge($this->data(), [
            'container' => $this,
        ]));
    }

    public function toHtml(): string
    {
        return $this->render()->render();
    }
}
