<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Relatable
{
    public function remoteRelations(): MorphMany
    {
        return $this->morphMany(config('asseco-remote-relations.remote_relation_class'), 'model');
    }

    public function relate(string $service, string $model, string $id): Model
    {
        $relation = $this->createRelation($service, $model, $id);
        $relation->save();
        $relation->refresh();

        return $relation;
    }

    public function relateQuietly(string $service, string $model, string $id): Model
    {
        $relation = $this->createRelation($service, $model, $id);
        $relation->saveQuietly();
        $relation->refresh();

        return $relation;
    }

    protected function createRelation(string $service, string $model, string $id): Model
    {
        return $this->remoteRelations()->make([
            'service'         => $service,
            'remote_model'    => $model,
            'remote_model_id' => $id,
        ]);
    }

    public function unrelate(string $service, string $model, string $id): void
    {
        $relation = $this->relationByServiceModelId($service, $model, $id);

        $relation->delete();
    }

    public function unrelateQuietly(string $service, string $model, string $id): void
    {
        $relation = $this->relationByServiceModelId($service, $model, $id);

        static::withoutEvents(function () use ($relation) {
            return $relation->delete();
        });
    }

    protected function relationByServiceModelId(string $service, string $model, string $id)
    {
        return $this->remoteRelations()
            ->where('service', $service)
            ->where('remote_model', $model)
            ->where('remote_model_id', $id)
            ->firstOrFail();
    }
}
