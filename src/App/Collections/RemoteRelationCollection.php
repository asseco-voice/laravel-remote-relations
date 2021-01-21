<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Collections;

use Asseco\RemoteRelations\RelationsResolver;
use Illuminate\Database\Eloquent\Collection;

class RemoteRelationCollection extends Collection
{
    public function resolve()
    {
        $resolvedRelations = (new RelationsResolver())->resolveRelations($this);

        return array_map(function ($resolvedRelation) {

            $originalRelationObject = $this->where('remote_model_id', $resolvedRelation['id'])->first();

            return array_merge(
                optional($originalRelationObject)->toArray() ?: [],
                ['data' => $resolvedRelation]
            );
        }, $resolvedRelations);
    }
}
