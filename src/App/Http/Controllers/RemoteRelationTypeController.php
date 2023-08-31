<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use Asseco\RemoteRelations\App\Contracts\RemoteRelationType as RemoteRelationTypeContract;
use Asseco\RemoteRelations\App\Http\Requests\RemoteRelationTypeRequest;
use Asseco\RemoteRelations\App\Models\RemoteRelationType;
use Illuminate\Http\JsonResponse;

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
     * @param  RemoteRelationTypeRequest  $request
     * @return JsonResponse
     */
    public function store(RemoteRelationTypeRequest $request): JsonResponse
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
     * @param  RemoteRelationTypeRequest  $request
     * @param  RemoteRelationType  $remoteRelationType
     * @return JsonResponse
     */
    public function update(RemoteRelationTypeRequest $request, RemoteRelationType $remoteRelationType): JsonResponse
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
