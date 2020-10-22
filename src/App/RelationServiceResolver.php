<?php

namespace Voice\ExternalRelations\App;

use Illuminate\Database\Eloquent\Collection;

class RelationServiceResolver extends ServiceResolver
{
    public static function resolveRelation(Relation $relation): array
    {
        return self::getContact($relation->id, auth()->user() ? auth()->user()->getTokenAsString() : null);
    }

    public static function resolveRelations(Collection $relations): array
    {
        $resolvedRelations = [];
        $internalRelations = [];
        $externalRelations = [];

        foreach ($relations as $relation) {
            if ($relation->relation_type === "internal") {
                $internalRelations[] = $relation;
                continue;
            }
            $externalRelations[] = $relation;
        }
        $resolvedRelations = array_merge($resolvedRelations, self::resolveInternalRelations($internalRelations));
        $resolvedRelations = array_merge($resolvedRelations, self::resolveExternalRelations($externalRelations));
        return $resolvedRelations;
    }

    public static function resolveInternalRelations(array $internalRelations): array
    {

        $mappedByService = [];

        $relatedIds = [];
        foreach ($internalRelations as $index => $relation) {
            if (!isset($mappedByService[$relation->service])){
                $mappedByService[$relation->service] = [];
            }
            if(!isset($mappedByService[$relation->service][$relation->model])){
                $mappedByService[$relation->service][$relation->model] = [];
            }

            if (!in_array($relation->model_id, $mappedByService[$relation->service][$relation->model])){
                $mappedByService[$relation->service][$relation->model][] = $relation->model_id;
            }
            $relatedIds[] = $relation->model_id;
        }

        return self::mapRelations($internalRelations, self::fetchFromArray($mappedByService));
    }

    public static function mapRelations(array $internalRelations, array $resolvedRelations): array
    {
        foreach ($internalRelations as $internalRelation) {
            foreach ($resolvedRelations as $service => $model) {
                if($internalRelation->service == $service){
                    foreach($model as $modelName => $modelValues){
                        if ($internalRelation->model == $modelName){
                            foreach ($modelValues as $modelValue){
                                if ($modelValue["id"] == $internalRelation->model_id) {
                                    $internalRelation->data = $modelValue;
                                    break;
                                }
                            }
                        }
                    }
                }
                
            }
        }
        return $internalRelations;
    }

    public static function fetchFromArray(array $mappedByService):array
    {
        $resolved = [];

        foreach($mappedByService as $index => $serviceModels){
            foreach ($serviceModels as $modelName => $modelIds){
                $resolved[$index][$modelName] = self::getContacts($modelIds);
            }
        }
        return $resolved;
    }   


    public static function resolveExternalRelations(array $externalRelations): array
    {
        return [];
    }
}
