<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Collections;

use Illuminate\Database\Eloquent\Collection;

class RemoteRelationCollection extends Collection
{
    protected const DATA = 'data';
    protected const RESOLUTION = 'resolution';

    /**
     * Overriding Laravel append method to support batching HTTP calls to external services.
     *
     * @param  array|string  $attributes
     * @return RemoteRelationCollection
     */
    public function append($attributes)
    {
        if (is_string($attributes) && $attributes == self::RESOLUTION) {
            $this->batchResolutions();

            return $this;
        }

        if (is_array($attributes) && in_array(self::RESOLUTION, $attributes)) {
            $this->batchResolutions();

            if (($key = array_search(self::RESOLUTION, $attributes)) !== false) {
                unset($attributes[$key]);
            }
        }

        return parent::append($attributes);
    }

    protected function batchResolutions(): void
    {
        $resolverClass = config('asseco-remote-relations.models.relations_resolver');

        $resolvedRelations = (new $resolverClass())->resolveRelations($this);

        $this->each(function ($remoteRelation) use ($resolvedRelations) {
            $data = array_filter($resolvedRelations, function ($resolvedRelation) use ($remoteRelation) {
                return $resolvedRelation['id'] == $remoteRelation->remote_model_id;
            });

            $remoteRelation->{self::DATA} = array_pop($data) ?: [];
        });
    }

    public function resolve()
    {
        $resolverClass = config('asseco-remote-relations.models.relations_resolver');

        $resolvedRelations = (new $resolverClass())->resolveRelations($this);

        return array_map(function ($resolvedRelation) {
            $originalRelationObject = $this->where('remote_model_id', $resolvedRelation['id'])->first();

            return array_merge(
                optional($originalRelationObject)->toArray() ?: [],
                [self::DATA => $resolvedRelation]
            );
        }, $resolvedRelations);
    }
}
