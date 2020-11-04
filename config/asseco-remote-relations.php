<?php

use Voice\RemoteRelations\App\RemoteRelation;

return [

    /**
     * Mapping of key => value pairs where key is a 'service' from 'remote_relations' table
     * and value is class implementing AbstractRemoteService.
     */
    'services' => [
        // 'some_service' => SomeService::class,
    ],

    /**
     * If needed, extend the class with additional features and replace with your own class.
     */
    'remote_relation_class' => RemoteRelation::class,
];
