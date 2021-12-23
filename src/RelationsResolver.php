<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations;

use Asseco\RemoteRelations\App\Contracts\HasRemoteRelations;
use Asseco\RemoteRelations\App\Exceptions\RemoteRelationException;
use Asseco\RemoteRelations\App\Models\RemoteRelation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class RelationsResolver
{
    /**
     * Resolve single relation.
     *
     * @param RemoteRelation $relation
     * @return array
     *
     * @throws RemoteRelationException
     */
    public function resolveRelation(RemoteRelation $relation): array
    {
        $service = $this->instantiateService($relation->service);

        return $service->resolveRemoteRelation($relation);
    }

    /**
     * Efficiently resolve relation collection grouping it by service/model.
     *
     * @param Collection $relations
     * @return array
     *
     * @throws RemoteRelationException
     */
    public function resolveRelations(Collection $relations): array
    {
        $relationsByService = $relations->groupBy(['service', 'remote_model_type']);

        $resolved = [];

        foreach ($relationsByService as $serviceClass => $relationsByModel) {
            $service = $this->instantiateService($serviceClass);

            foreach ($relationsByModel as $model => $relationCollection) {
                $resolved = array_merge($resolved, $service->resolveRemoteRelations($model, $relationCollection));
            }
        }

        return $resolved;
    }

    /**
     * @param string $serviceClass
     * @return HasRemoteRelations
     *
     * @throws RemoteRelationException
     */
    protected function instantiateService(string $serviceClass): HasRemoteRelations
    {
        $service = Arr::get(config('services'), "$serviceClass.sdk");

        if (!$service) {
            throw new RemoteRelationException("Service '$serviceClass' is not registered");
        }

        return new $service;
    }
}
