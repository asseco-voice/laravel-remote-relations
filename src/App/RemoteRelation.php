<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RemoteRelation extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
