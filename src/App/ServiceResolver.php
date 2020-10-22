<?php

namespace Voice\ExternalRelations\App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServiceResolver
{
    const mapping = [
        "address-book" => [
            "contact"
        ],
        "communication" => [
            "email"
        ],
        "templating" => [
            "record"
        ]
    ];

    public static function get(string $service, string $model, array $ids){
        $resolver = self::mapping[$service][$model];
        $resolver = new $resolver();
        $resolver->get($ids);
    }


    public static function getContacts(array $ids, string $token = null): array
    {
        $hostname = config("asseco-chassis.service_endpoints.address_book");
        $http = Http::asJson();
        if ($token) {
            $http->withToken($token);
        }
        $response = $http->post(
            $hostname . "/api/search/contact",
            [
                "search" => [
                    "id" => self::getSearchString($ids)
                ]
            ]
        );
        if ($response->failed()) {
            Log::error(print_r($response->json(), true));
        }
        return $response->json();
    }



    public static function getContact(string $id, string $token = null): array
    {
        $hostname = config("asseco-chassis.service_endpoints.address_book");
        $http = Http::asJson();
        if ($token) {
            $http->withToken($token);
        }
        $response = $http->get($hostname . "/api/contacts/" . $id);
        if ($response->failed()) {
            Log::error(print_r($response->json(), true));
        }
        return $response->json();
    }

    private static function getSearchString(array $ids): string
    {
        $searchString = "=";
        foreach ($ids as $id) {
            $searchString .= $id . ";";
        }

        return $searchString;
    }
}
