<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Models;

use Asseco\RemoteRelations\App\Contracts\RemoteRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RemoteRelationType extends Model implements \Asseco\RemoteRelations\App\Contracts\RemoteRelationType
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function remoteRelations(): HasMany
    {
        return $this->hasMany(get_class(app(RemoteRelation::class)));
    }
}
