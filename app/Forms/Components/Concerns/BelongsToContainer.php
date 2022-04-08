<?php

namespace App\Forms\Components\Concerns;

use App\Forms\ComponentContainer;
//use App\Forms\Contracts\HasForms;

trait BelongsToContainer
{
    /**
     * @var \App\Forms\ComponentContainer
     */
    protected $container;

    /**
     * @return $this
     */
    public function container(ComponentContainer $container)
    {
        $this->container = $container;

        return $this;
    }

    public function getContainer(): ComponentContainer
    {
        return $this->container;
    }

//    public function getLivewire(): HasForms
//    {
//        return $this->getContainer()->getLivewire();
//    }
}
