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
        $remoteId = $request->get('remote_id');

        if (!empty($remoteId)) {
            $this->remoteRelation->query()
                ->where('service', $service)
                ->where('model_id', $remoteId)
                ->where('remote_model_type', $model)
                ->where('remote_model_id', $id)
                ->update([
                    'acknowledged' => now('UTC'),
                ]);
        }
        else {
            $this->remoteRelation->query()
                ->where('service', $service)
                ->where('remote_model_type', $model)
                ->where('remote_model_id', $id)
                ->update([
                    'acknowledged' => now('UTC'),
                ]);
        }

        return response()->json('OK', 200);
    }
}
