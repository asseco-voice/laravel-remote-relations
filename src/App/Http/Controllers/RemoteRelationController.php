<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use Asseco\RemoteRelations\App\Contracts\RemoteRelation as RemoteRelationContract;
use Asseco\RemoteRelations\App\Http\Requests\RemoteRelationManyRequest;
use Asseco\RemoteRelations\App\Models\RemoteRelation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemoteRelationController extends Controller
{
    public RemoteRelationContract $remoteRelation;

    public function __construct(RemoteRelationContract $remoteRelation)
    {
        $this->remoteRelation = $remoteRelation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->remoteRelation::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $remoteRelation = $this->remoteRelation::query()->create($request->all());

        return response()->json($remoteRelation->refresh());
    }

    public function storeMany(RemoteRelationManyRequest $request)
    {
        $relations = $request->validated();

        DB::transaction(function () use ($relations) {
            foreach ($relations as $relation) {
                $this->remoteRelation::query()->create($relation);
            }
        });

        return response()->json('success');
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
