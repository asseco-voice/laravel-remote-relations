<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Models;

use Asseco\RemoteRelations\App\Collections\RemoteRelationCollection;
use Asseco\RemoteRelations\App\Contracts\RelationsResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Log;

class RemoteRelation extends Model implements \Asseco\RemoteRelations\App\Contracts\RemoteRelation
{
    use HasFactory;

    const DATA_KEY = 'data';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'acknowledged' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function (self $remoteRelation) {
            config('asseco-remote-relations.events.remote_relation_created')::dispatch($remoteRelation);
        });

        static::saving(function (self $remoteRelation) {
            if ($remoteRelation->exists()) {
                Log::info("Remote relation already exists and won't be saved: "
                    . print_r($remoteRelation->toArray(), true));

                return false;
            }
        });
    }

    public function getResolutionAttribute()
    {
        return app(RelationsResolver::class)->resolveRelation($this);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function resolve()
    {
        $resolvedRelation = app(RelationsResolver::class)->resolveRelation($this);

        return array_merge($this->toArray(), [self::DATA_KEY => $resolvedRelation]);
    }

    public function newCollection(array $models = [])
    {
        return new RemoteRelationCollection($models);
    }

    protected function exists(): bool
    {
        return $this->isDirty([
            'model_id',
            'model_type',
            'service',
            'remote_model_type',
            'remote_model_id',
        ]) && config('asseco-remote-relations.models.remote_relation')::query()
                ->where('model_id', $this->model_id)
                ->where('model_type', $this->model_type)
                ->where('service', $this->service)
                ->where('remote_model_type', $this->remote_model_type)
                ->where('remote_model_id', $this->remote_model_id)
                ->exists();
    }
}
