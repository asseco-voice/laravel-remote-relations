<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Asseco\RemoteRelations\App\RemoteRelation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RemoteRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(RemoteRelation::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $remoteRelation = RemoteRelation::query()->create($request->all());

        return response()->json($remoteRelation->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param RemoteRelation $remoteRelation
     * @return JsonResponse
     */
    public function show(RemoteRelation $remoteRelation): JsonResponse
    {
        return response()->json($remoteRelation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param RemoteRelation $remoteRelation
     * @return JsonResponse
     */
    public function update(Request $request, RemoteRelation $remoteRelation): JsonResponse
    {
        $remoteRelation->update($request->all());

        return response()->json($remoteRelation->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RemoteRelation $remoteRelation
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(RemoteRelation $remoteRelation): JsonResponse
    {
        $isDeleted = $remoteRelation->delete();

        return response()->json($isDeleted ? 'true' : 'false');
    }
}
