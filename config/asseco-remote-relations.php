<?php

use Asseco\BlueprintAudit\App\MigrationMethodPicker;
use Asseco\RemoteRelations\App\Events\RemoteRelationCreated;
use Asseco\RemoteRelations\App\Models\RemoteRelation;
use Asseco\RemoteRelations\App\Models\RemoteRelationType;
use Asseco\RemoteRelations\RelationsResolver;

return [

    /**
     * Model bindings.
     */
    'models' => [
        'remote_relation'      => RemoteRelation::class,
        'remote_relation_type' => RemoteRelationType::class,
        'relations_resolver'   => RelationsResolver::class,
    ],

    'events' => [
        'remote_relation_created' => RemoteRelationCreated::class,
    ],

    'migrations' => [

        /**
         * UUIDs as primary keys.
         */
        'uuid'       => false,

        /**
         * Timestamp types.
         *
         * @see https://github.com/asseco-voice/laravel-common/blob/master/config/asseco-common.php
         */
        'timestamps' => MigrationMethodPicker::PLAIN,

        /**
         * Should the package run the migrations. Set to false if you're publishing
         * and changing default migrations.
         */
        'run'        => true,
    ],

    'routes' => [
        'prefix'     => 'api',
        'middleware' => ['api'],
    ],
];
