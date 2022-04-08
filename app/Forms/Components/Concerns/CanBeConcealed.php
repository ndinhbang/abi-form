<?php

namespace App\Forms\Components\Concerns;

use App\Forms\Components\Component;
use App\Forms\Components\Contracts\CanConcealComponents;

trait CanBeConcealed
{
    public function getConcealingComponent(): ?Component
    {
        $parentComponent = $this->getContainer()->getParentComponent();

        if (! $parentComponent) {
            return null;
        }

        if (! $parentComponent instanceof CanConcealComponents) {
            return $parentComponent->getConcealingComponent();
        }

        return $parentComponent;
    }
}
