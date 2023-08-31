<?php

use Asseco\BlueprintAudit\App\MigrationMethodPicker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remote_relation_types', function (Blueprint $table) {
            if (config('asseco-remote-relations.migrations.uuid')) {
                $table->uuid('id')->primary();
            } else {
                $table->id();
            }
            $table->string('name');
            $table->string('label');
            $table->string('inverse_name');
            $table->string('inverse_label');

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
        Schema::drop('remote_relation_types');
    }
};
