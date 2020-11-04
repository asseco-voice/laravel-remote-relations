<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App\Collections;

use Illuminate\Database\Eloquent\Collection;
use Voice\RemoteRelations\RelationsResolver;

class RemoteRelationCollection extends Collection
{
    public function resolve()
    {
        $resolvedRelations = (new RelationsResolver())->resolveRelations($this);

        return array_map(function ($resolvedRelation) {
            return array_merge(
                $this->where('remote_model_id', $resolvedRelation['id'])->first()->toArray(),
                ['data' => $resolvedRelation]
            );
        }, $resolvedRelations);
    }
}
