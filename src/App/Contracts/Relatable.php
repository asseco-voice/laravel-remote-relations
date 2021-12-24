<?php

namespace Asseco\RemoteRelations\App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Relatable
{
    public function remoteRelations(): MorphMany;

    public function relate(string $service, string $model, $id): Model;

    public function relateQuietly(string $service, string $model, $id): Model;

    public function unrelate(string $service, string $model, $id, bool $force = false): void;

    public function unrelateQuietly(string $service, string $model, $id, bool $force = false): void;
}