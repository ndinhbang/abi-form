<?php

namespace App\Resources;

use Closure;
use App\Forms\Components\Component;
use App\Forms\Components\Grid;

class Form
{
    /**
     * @var mixed[]|int|null
     */
    protected $columns = null;

    /**
     * @var mixed[]|\Closure|\App\Forms\Components\Component
     */
    protected $schema = [];

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
     * @param mixed[]|int|null $columns
     * @return $this
     */
    public function columns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param mixed[]|\Closure|\App\Forms\Components\Component $schema
     * @return $this
     */
    public function schema($schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return mixed[]|int|null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    public function getSchema(): array
    {
        $schema = $this->schema;

        if (is_array($schema) || $schema instanceof Closure) {
            $schema = Grid::make()
                ->schema($schema)
                ->columns($this->getColumns());
        }

        return [$schema];
    }
}
