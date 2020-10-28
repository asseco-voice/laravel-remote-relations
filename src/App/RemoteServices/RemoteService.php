<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App\RemoteServices;

use Illuminate\Support\Collection;

interface RemoteService
{
    public function resolve(string $model, Collection $relations): array;
}
