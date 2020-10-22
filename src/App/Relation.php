<?php

namespace Voice\ExternalRelations\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Relation extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function relatable(): MorphTo
    {
        return $this->morphTo();
    }
}
