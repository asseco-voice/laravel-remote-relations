<?php

declare(strict_types=1);

namespace Voice\RemoteRelations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Voice\RemoteRelations\App\RemoteRelation;

class RemoteRelationController extends Controller
{
    public function show(RemoteRelation $remoteRelation)
    {
        return Response::json($remoteRelation);
    }
}
