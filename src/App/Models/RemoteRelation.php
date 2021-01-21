<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Models;

use Asseco\RemoteRelations\App\Collections\RemoteRelationCollection;
use Asseco\RemoteRelations\RelationsResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RemoteRelation extends Model
{
    use HasFactory;

    const DATA_KEY = 'data';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function resolve()
    {
        $resolvedRelation = (new RelationsResolver())->resolveRelation($this);

        return array_merge($this->toArray(), [self::DATA_KEY => $resolvedRelation]);
    }

    public function newCollection(array $models = [])
    {
        return new RemoteRelationCollection($models);
    }
}
