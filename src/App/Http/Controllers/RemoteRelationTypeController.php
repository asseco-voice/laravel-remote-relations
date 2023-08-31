<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use Asseco\RemoteRelations\App\Contracts\RemoteRelationType as RemoteRelationTypeContract;
use Asseco\RemoteRelations\App\Models\RemoteRelationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RemoteRelationTypeController extends Controller
{
    public RemoteRelationTypeContract $remoteRelationType;

    public function __construct(RemoteRelationTypeContract $remoteRelationType)
    {
        $this->remoteRelationType = $remoteRelationType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->remoteRelationType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $remoteRelationType = $this->remoteRelationType::query()->create($request->all());

        return response()->json($remoteRelationType->refresh());
    }

    /**
     * Display the specified resource.
     *
     * @param  RemoteRelationType  $remoteRelationType
     * @return JsonResponse
     */
    public function show(RemoteRelationType $remoteRelationType): JsonResponse
    {
        return response()->json($remoteRelationType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  RemoteRelationType  $remoteRelationType
     * @return JsonResponse
     */
    public function update(Request $request, RemoteRelationType $remoteRelationType): JsonResponse
    {
        $remoteRelationType->update($request->all());

        return response()->json($remoteRelationType->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  RemoteRelationType  $remoteRelationType
     * @return JsonResponse
     */
    public function destroy(RemoteRelationType $remoteRelationType): JsonResponse
    {
        $isDeleted = $remoteRelationType->delete();

        return response()->json($isDeleted ? 'true' : 'false');
    }
}
