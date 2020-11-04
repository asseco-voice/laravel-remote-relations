<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;

trait Relatable
{
    public function remoteRelations(): MorphMany
    {
        return $this->morphMany(Config::get('asseco-remote-relations.remote_relation_class'), 'model');
    }

    public function relate(string $service, string $model, string $id)
    {
        $this->remoteRelations()->create([
            'service'         => $service,
            'remote_model'    => $model,
            'remote_model_id' => $id,
        ]);
    }
}
