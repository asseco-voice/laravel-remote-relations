<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $date = now()->toDateString();

        $builder
            ->where(function (Builder $q) use ($date) {
                $q->whereNull('valid_from')->orWhereDate('valid_from', '<=', $date);
            })
            ->where(function (Builder $q) use ($date) {
                $q->whereNull('valid_to')->orWhereDate('valid_to', '>=', $date);
            });
    }
}
