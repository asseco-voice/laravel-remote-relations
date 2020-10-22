<?php

declare(strict_types=1);

namespace Voice\ExternalRelations\App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Voice\ExternalRelations\App\Relation;
use Illuminate\Database\Eloquent\Collection;
use Voice\ExternalRelations\App\RelationServiceResolver;

trait Relatable
{
    public function relations(): MorphMany
    {
        return $this->morphMany(Relation::class, 'relatable');
    }

    public function relate(string $service, string $model, string $id, string $type = "internal")
    {
        $this->relations()->create([
            "service" => $service,
            "model" => $model,
            "model_id" => $id,
            "relation_type" => $type
        ]);
    }


    public function resolve(): array
    {
        $resolved = [];

        $resolvers = config("asseco-external-relations.resolvers");

        $sortedRelations = [];

        foreach ($this->relations()->getResults() as $relation) {
            if (isset($resolvers[$relation->relation_type])) {
                $sortedRelations[$relation->relation_type][] = $relation;
            }
        }

        foreach ($sortedRelations as $type => $relations) {
            $resolver = RelationServiceResolver::getResolver($type);

            if (count($relations) > 1){
                $resolved = array_merge($resolved, $resolver->handleMany(new Collection($relations)));
            }else{
                $resolved = array_merge($resolved, $resolver->handleOne($relations[0]));
            }

            
        }

        return $resolved;
    }
}
