<?php

namespace Asseco\RemoteRelations\App\Events;

use Asseco\RemoteRelations\App\Contracts\RemoteRelation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RemoteRelationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public const REMOTE_RELATION_CHANNEL = 'remote_relations';

    public RemoteRelation $remoteRelation;

    /**
     * Create a new event instance.
     *
     * @param  RemoteRelation  $remoteRelation
     */
    public function __construct(RemoteRelation $remoteRelation)
    {
        $this->remoteRelation = $remoteRelation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [$this::REMOTE_RELATION_CHANNEL];
    }
}
