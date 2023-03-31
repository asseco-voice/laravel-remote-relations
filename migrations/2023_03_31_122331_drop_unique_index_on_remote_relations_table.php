<?php

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
        Schema::table('remote_relations', function (Blueprint $table) {
            $table->dropIndex('remote_composite_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remote_relations', function (Blueprint $table) {
            $table->unique(['model_id', 'model_type', 'service', 'remote_model_type', 'remote_model_id'], 'remote_composite_index');
        });
    }
};
