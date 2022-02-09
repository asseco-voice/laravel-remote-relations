<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use Asseco\RemoteRelations\App\Models\RemoteRelation;
use Illuminate\Http\JsonResponse;

class ResolveRemoteRelationController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  RemoteRelation  $remoteRelation
     * @return JsonResponse
     */
    public function __invoke(RemoteRelation $remoteRelation): JsonResponse
    {
        return response()->json($remoteRelation->resolve()[RemoteRelation::DATA_KEY]);
    }
}
