<?php

namespace App\Navigation;

class UserMenuItem
{
    /**
     * @var string|null
     */
    protected $color = null;

    /**
     * @var string|null
     */
    protected $icon = null;

    /**
     * @var string|null
     */
    protected $label = null;

    /**
     * @var int|null
     */
    protected $sort = null;

    /**
     * @var string|null
     */
    protected $url = null;

    final public function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function make()
    {
        return app(static::class);
    }

    /**
     * @return $this
     */
    public function color(?string $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return $this
     */
    public function icon(?string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return $this
     */
    /**
     * @return $this
     */
    public function label(?string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return $this
     */
    public function sort(?int $sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return $this
     */
    public function url(?string $url)
    {
        $this->url = $url;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getSort(): int
    {
        return $this->sort ?? -1;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }
}
