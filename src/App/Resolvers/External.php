<?php

namespace Voice\ExternalRelations\App\Resolvers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Voice\ExternalRelations\App\ExternalRelation;
use Voice\ExternalRelations\App\Interfaces\ResolverInterface;

class External implements ResolverInterface
{

    public function handleOne(ExternalRelation $relation): array
    {
        $http = Http::asJson();
        $response = $http->get(
            $relation->service . "/api/" . $relation->model . "s/" . $relation->model_id
        );
        if ($response->failed()) {
            Log::error(print_r($response->json(), true));
        }
        return $response->json();
    }

    public function handleMany(Collection $relations): array
    {
        return [];
    }
}
