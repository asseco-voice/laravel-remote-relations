<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Models;

use Asseco\RemoteRelations\App\Collections\RemoteRelationCollection;
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

    public function getResolutionAttribute()
    {
        $resolverClass = config('asseco-remote-relations.models.relations_resolver');

        return (new $resolverClass())->resolveRelation($this);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function resolve()
    {
        $resolverClass = config('asseco-remote-relations.models.relations_resolver');

        $resolvedRelation = (new $resolverClass())->resolveRelation($this);

        return array_merge($this->toArray(), [self::DATA_KEY => $resolvedRelation]);
    }

    public function newCollection(array $models = [])
    {
        return new RemoteRelationCollection($models);
    }
}
