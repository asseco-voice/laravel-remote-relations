<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RemoteServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return config('asseco-remote-relations.services');
    }
}
