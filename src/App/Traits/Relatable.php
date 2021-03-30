<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Relatable
{
    public function remoteRelations(): MorphMany
    {
        return $this->morphMany(config('asseco-remote-relations.remote_relation_class'), 'model');
    }

    public function relate(string $service, string $model, $id): Model
    {
        $relation = $this->createRelation($service, $model, $id);
        $relation->save();
        $relation->refresh();

        return $relation;
    }

    public function relateQuietly(string $service, string $model, $id): Model
    {
        $relation = $this->createRelation($service, $model, $id);
        $relation->saveQuietly();
        $relation->refresh();

        return $relation;
    }

    protected function createRelation(string $service, string $model, $id): Model
    {
        throw_if(!in_array($service, array_keys(config('asseco-remote-relations.services'))),
            new \Exception("Service $service is not defined"));

        return $this->remoteRelations()->make([
            'service'           => $service,
            'remote_model_type' => $model,
            'remote_model_id'   => $id,
        ]);
    }

    public function unrelate(string $service, string $model, $id, bool $force = false): void
    {
        $relation = $this->relationByServiceModelId($service, $model, $id);

        $force ? $relation->forceDelete() : $relation->delete();
    }

    public function unrelateQuietly(string $service, string $model, $id, bool $force = false): void
    {
        $relation = $this->relationByServiceModelId($service, $model, $id);

        static::withoutEvents(function () use ($relation, $force) {
            $force ? $relation->forceDelete() : $relation->delete();
        });
    }

    protected function relationByServiceModelId(string $service, string $model, $id)
    {
        return $this->remoteRelations()
            ->where('service', $service)
            ->where('remote_model_type', $model)
            ->where('remote_model_id', $id)
            ->firstOrFail();
    }
}
