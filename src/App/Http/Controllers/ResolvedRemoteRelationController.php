<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Asseco\RemoteRelations\App\RemoteRelation;
use Illuminate\Http\JsonResponse;

class ResolvedRemoteRelationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param RemoteRelation $remoteRelation
     * @return JsonResponse
     */
    public function show(RemoteRelation $remoteRelation): JsonResponse
    {
        return response()->json($remoteRelation->resolve()[RemoteRelation::DATA_KEY]);
    }
}
