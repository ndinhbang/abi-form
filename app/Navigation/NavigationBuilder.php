<?php

namespace App\Navigation;

use Illuminate\Support\Traits\Conditionable;

class NavigationBuilder
{
    use Conditionable;

    /** @var array<string, \App\Navigation\NavigationItem[]> */
    protected $groups = [];

    /** @var \App\Navigation\NavigationItem[] */
    protected $items = [];

    /**
     * @param  string  $name
     * @param  array   $items
     * @return $this
     */
    public function group(string $name, array $items = [])
    {
        $this->groups[$name] = collect($items)->map(
            function (NavigationItem $item, int $index) use ($name) {
                return $item->group($name)->sort($index);
            }
        )->toArray();

        return $this;
    }

    /**
     * @param  \App\Navigation\NavigationItem  $item
     * @return $this
     */
    public function item(NavigationItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /** @param \App\Navigation\NavigationItem[] $items
     * @return $this */
    public function items(array $items)
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
