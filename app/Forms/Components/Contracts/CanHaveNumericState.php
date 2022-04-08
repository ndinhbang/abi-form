<?php

namespace App\Forms\Components\Contracts;

interface CanHaveNumericState
{
    public function isNumeric(): bool;
}
