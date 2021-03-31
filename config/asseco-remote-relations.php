<?php

use Asseco\RemoteRelations\App\Models\RemoteRelation;

return [

    /**
     * Mapping of key => value pairs where key is a 'service' from 'remote_relations' table
     * and value is class implementing HasRemoteRelations interface.
     */
    'services' => [
        // 'some_service' => SomeService::class,
    ],

    /**
     * If needed, extend the class with additional features and replace with your own class.
     */
    'remote_relation_class' => RemoteRelation::class,

    /**
     * Path to original stub which will create the migration upon publishing.
     */
    'stub_path' => '/../migrations/create_remote_relations_table.php.stub',
];
