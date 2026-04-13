<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Traits;

use Asseco\RemoteRelations\App\Contracts\RemoteRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

trait Relatable
{
    public function remoteRelations(): MorphMany
    {
        return $this->morphMany(get_class(app(RemoteRelation::class)), 'model');
    }

    public function relate(
        string $service,
        string $model,
        $id,
        bool $acknowledged = false,
        $typeId = null,
        ?string $validFrom = null,
        ?string $validTo = null,
    ): Model {
        $relation = $this->createRelation($service, $model, $id, $acknowledged, $typeId, $validFrom, $validTo);
        $relation->save();
        $relation->refresh();

        return $relation;
    }

    public function relateQuietly(
        string $service,
        string $model,
        $id,
        bool $acknowledged = false,
        $typeId = null,
        ?string $validFrom = null,
        ?string $validTo = null,
    ): Model {
        $relation = $this->createRelation($service, $model, $id, $acknowledged, $typeId, $validFrom, $validTo);
        $relation->saveQuietly();
        $relation->refresh();

        return $relation;
    }

    protected function createRelation(
        string $service,
        string $model,
        $id,
        bool $acknowledged,
        $typeId = null,
        ?string $validFrom = null,
        ?string $validTo = null,
    ): Model {
        $attributes = [
            'service' => $service,
            'remote_model_type' => $model,
            'remote_model_id' => $id,
            'acknowledged' => $acknowledged ? now('UTC') : null,
            'remote_relation_type_id' => $typeId,
            'valid_from' => $validFrom,
            'valid_to' => $validTo,
        ];

        if (config('asseco-remote-relations.migrations.uuid')) {
            $attributes['id'] = Str::uuid();
        }

        return $this->remoteRelations()->make($attributes);
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
            ->where('model_id', $this->id)
            ->where('remote_model_type', $model)
            ->where('remote_model_id', $id)
            ->firstOrFail();
    }
}
