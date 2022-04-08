<?php

namespace App\Navigation;

use Closure;

class NavigationItem
{
    /**
     * @var string|null
     */
    protected $group;

    /**
     * @var \Closure|null
     */
    protected $isActiveWhen;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string|null
     */
    protected $badge;

    /**
     * @var bool
     */
    protected $shouldOpenUrlInNewTab = false;

    /**
     * @var int|null
     */
    protected $sort;

    /**
     * @var \Closure|string|null
     */
    protected $url;

    final public function __construct()
    {
    }

    /**
     * @param  string|null  $badge
     * @return $this
     */
    public function badge(?string $badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * @param  string|null  $group
     * @return $this
     */
    public function group(?string $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @param  string  $icon
     * @return $this
     */
    public function icon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param  \Closure  $callback
     * @return $this
     */
    public function isActiveWhen(Closure $callback)
    {
        $this->isActiveWhen = $callback;

        return $this;
    }

    /**
     * @param  string  $label
     * @return $this
     */
    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return $this
     */
    public static function make()
    {
        return app(static::class);
    }

    /**
     * @param  bool  $condition
     * @return $this
     */
    public function openUrlInNewTab(bool $condition = true)
    {
        $this->shouldOpenUrlInNewTab = $condition;

        return $this;
    }

    /**
     * @param  int|null  $sort
     * @return $this
     */
    public function sort(?int $sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @param  \Closure|string|null  $url
     * @param  bool                  $shouldOpenInNewTab
     * @return $this
     */
    public function url(?string $url, bool $shouldOpenInNewTab = false)
    {
        $this->shouldOpenUrlInNewTab = $shouldOpenInNewTab;
        $this->url = $url;

        return $this;
    }

    public function getBadge(): ?string
    {
        return $this->badge;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSort(): int
    {
        return $this->sort ?? -1;
    }

    public function getUrl(): ?string
    {
        return value($this->url);
    }

    public function isActive(): bool
    {
        $callback = $this->isActiveWhen;

        if ($callback === null) {
            return false;
        }

        return app()->call($callback);
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return $this->shouldOpenUrlInNewTab;
    }
}
