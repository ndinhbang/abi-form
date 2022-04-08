<?php

namespace App\Forms\Contracts;

interface HasForms
{
    public function dispatchFormEvent(...$args): void;

    public function validate(?array $rules = null, array $messages = [], array $attributes = []);
}
