<?php

declare(strict_types=1);

namespace Asseco\RemoteRelations\App\Http\Controllers;

use Asseco\RemoteRelations\App\Contracts\RemoteRelation as RemoteRelationContract;
use Asseco\RemoteRelations\App\Http\Requests\AcknowledgeRemoteRelationRequest;

class AcknowledgeRemoteRelationController extends Controller
{
    public RemoteRelationContract $remoteRelation;

    public function __construct(RemoteRelationContract $remoteRelation)
    {
        $this->remoteRelation = $remoteRelation;
    }

    public function __invoke(AcknowledgeRemoteRelationRequest $request)
    {
        $service = $request->get('service');
        $model = $request->get('model');
        $id = $request->get('id');

        $this->remoteRelation->query()
            ->where('service', $service)
            ->where('remote_model_type', $model)
            ->where('remote_model_id', $id)
            ->update([
                'acknowledged' => now('UTC'),
            ]);

        return response()->isOk();
    }
}
