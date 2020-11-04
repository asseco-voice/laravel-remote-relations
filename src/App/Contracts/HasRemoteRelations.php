<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App\Contracts;

use Illuminate\Support\Collection;
use Voice\RemoteRelations\App\RemoteRelation;

interface HasRemoteRelations
{
    public function resolveRemoteRelation(RemoteRelation $relation): array;

    public function resolveRemoteRelations(string $remoteModel, Collection $relations): array;
}
