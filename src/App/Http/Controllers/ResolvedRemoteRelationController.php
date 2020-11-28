<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Asseco\RemoteRelations\App\RemoteRelation;

class ResolvedRemoteRelationController extends Controller
{
    public function show(RemoteRelation $remoteRelation)
    {
        return response()->json($remoteRelation->resolve()[RemoteRelation::DATA_KEY]);
    }
}
