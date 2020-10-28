<?php

declare(strict_types=1);

namespace Voice\RemoteRelations;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Voice\RemoteRelations\App\RemoteServices\RemoteService;

class RelationsResolver
{
    protected array $services = [];

    public function __construct()
    {
        $this->services = Config::get('asseco-remote-relations.services');
    }

    public function resolve(Collection $relations): array
    {
        $relationsByService = $relations->groupBy(['service', 'model']);

        $resolved = [];

        foreach ($relationsByService as $serviceClass => $relationsByModel) {

            $service = $this->instantiateService($serviceClass);

            foreach ($relationsByModel as $model => $relationCollection) {

                $resolved = array_merge($resolved, $service->resolve($model, $relationCollection));
            }
        }

        return $resolved;
    }

    protected function instantiateService(string $serviceClass): RemoteService
    {
        if (!in_array($serviceClass, $this->services)) {
            throw new Exception("Service '$serviceClass' is not registered");
        }

        return new $serviceClass;
    }
}
