<?php

declare(strict_types=1);

namespace Voice\ExternalRelations\App\Traits;

use Voice\ExternalRelations\App\RelationServiceResolver;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Voice\ExternalRelations\Relation;

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

    public function resolveRelations(): array
    {
        if(empty($this->relations["relations"])){
            return [];
        }
        return RelationServiceResolver::resolveRelations($this->relations["relations"]);
    }
}
