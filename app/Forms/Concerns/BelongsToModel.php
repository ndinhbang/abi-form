<?php

namespace App\Forms\Concerns;

use Illuminate\Database\Eloquent\Model;

trait BelongsToModel
{
    /**
     * @var \Illuminate\Database\Eloquent\Model|string|null
     */
    public $model = null;

    /**
     * @param \Illuminate\Database\Eloquent\Model|string|null $model
     * @return $this
     */
    public function model($model = null)
    {
        $this->model = $model;

        return $this;
    }

    public function saveRelationships(): void
    {
        foreach ($this->getComponents() as $component) {
            if ($component->getRecord()) {
                $component->saveRelationships();
            }

            foreach ($component->getChildComponentContainers() as $container) {
                if ($container->isHidden()) {
                    continue;
                }

                $container->saveRelationships();
            }
        }
    }

    public function getModel(): ?string
    {
        $model = $this->model;

        if ($model instanceof Model) {
            return get_class($model);
        }

        if (filled($model)) {
            return $model;
        }

        return optional($this->getParentComponent())->getModel();
    }

    public function getRecord(): ?Model
    {
        $model = $this->model;

        if ($model instanceof Model) {
            return $model;
        }

        if (is_string($model)) {
            return null;
        }

        return optional($this->getParentComponent())->getRecord();
    }

    public function getModelInstance(): ?Model
    {
        $model = $this->model;

        if ($model === null) {
            return optional($this->getParentComponent())->getModelInstance();
        }

        if ($model instanceof Model) {
            return $model;
        }

        return app($model);
    }
}
