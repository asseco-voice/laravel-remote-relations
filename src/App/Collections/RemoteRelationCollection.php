<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Collections;

use Asseco\RemoteRelations\RelationsResolver;
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
        if ($this->resolutionInString($attributes)) {
            $this->batchResolutions();

            return $this;
        }

        if ($this->resolutionInArray($attributes)) {
            $this->batchResolutions();

            if (($key = array_search(self::RESOLUTION, $attributes)) !== false) {
                unset($attributes[$key]);
            }
        }

        return parent::append($attributes);
    }

    protected function resolutionInString(string $attributes): bool
    {
        return is_string($attributes) && $attributes == self::RESOLUTION;
    }

    protected function resolutionInArray(string $attributes): bool
    {
        return is_array($attributes) && in_array(self::RESOLUTION, $attributes);
    }

    protected function batchResolutions(): void
    {
        $resolvedRelations = (new RelationsResolver())->resolveRelations($this);

        $this->each(function ($remoteRelation) use ($resolvedRelations) {
            $data = array_filter($resolvedRelations, function ($resolvedRelation) use ($remoteRelation) {
                return $resolvedRelation['id'] == $remoteRelation->remote_model_id;
            });

            $remoteRelation->{self::DATA} = array_pop($data) ?: [];
        });
    }

    public function resolve()
    {
        $resolvedRelations = (new RelationsResolver())->resolveRelations($this);

        return array_map(function ($resolvedRelation) {
            $originalRelationObject = $this->where('remote_model_id', $resolvedRelation['id'])->first();

            return array_merge(
                optional($originalRelationObject)->toArray() ?: [],
                [self::DATA => $resolvedRelation]
            );
        }, $resolvedRelations);
    }
}
