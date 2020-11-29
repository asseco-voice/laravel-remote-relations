<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Contracts;

use Asseco\RemoteRelations\App\RemoteRelation;
use Illuminate\Support\Collection;

interface HasRemoteRelations
{
    public function resolveRemoteRelation(RemoteRelation $relation): array;

    public function resolveRemoteRelations(string $remoteModel, Collection $relations): array;
}
