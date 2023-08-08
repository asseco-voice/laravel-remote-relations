<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Models;

use Asseco\RemoteRelations\App\Collections\RemoteRelationCollection;
use Asseco\RemoteRelations\App\Contracts\RelationsResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
}
