<?php

use Asseco\BlueprintAudit\App\MigrationMethodPicker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemoteRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remote_relations', function (Blueprint $table) {
            if (config('asseco-remote-relations.migrations.uuid')) {
                $table->uuid('id')->primary();
                $table->uuidMorphs('model');
                $table->uuidMorphs('remote_model');
            } else {
                $table->id();
                $table->morphs('model');
                $table->morphs('remote_model');
            }

            $table->string('service');

            $table->unique(['model_id', 'model_type', 'service', 'remote_model_type', 'remote_model_id'], 'remote_composite_index');

            MigrationMethodPicker::pick($table, config('asseco-remote-relations.migrations.timestamps'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remote_relations');
    }
}
