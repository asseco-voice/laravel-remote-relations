<?php

namespace Voice\ExternalRelations\App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Voice\ExternalRelations\App\ExternalRelation;

interface ResolverInterface {
    public function handleOne(ExternalRelation $relation):array;
    public function handleMany(Collection $relations):array;
}