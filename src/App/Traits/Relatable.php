<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Voice\RemoteRelations\App\RemoteRelation;
use Voice\RemoteRelations\RelationsResolver;

trait Relatable
{
    public function remoteRelations(): MorphMany
    {
        return $this->morphMany(RemoteRelation::class, 'model');
    }

    public function relate(string $service, string $model, string $id)
    {
        $this->remoteRelations()->create([
            'service'         => $service,
            'remote_model'    => $model,
            'remote_model_id' => $id,
        ]);
    }

    public function resolveRemoteRelations(): array
    {
        return (new RelationsResolver())->resolve($this->remoteRelations);
    }
}
