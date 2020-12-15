<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RemoteRelationServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(config('asseco-remote-relations.services'));
    }
}
