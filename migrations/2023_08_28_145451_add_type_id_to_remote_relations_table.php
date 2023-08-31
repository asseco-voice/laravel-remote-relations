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
            if (config('asseco-remote-relations.migrations.uuid')) {
                $table->foreignUuid('remote_relation_type_id')->nullable()->constrained()->cascadeOnDelete();
            } else {
                $table->foreignId('remote_relation_type_id')->nullable()->constrained()->cascadeOnDelete();
            }
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
            $table->dropForeign(['remote_relation_type_id']);
            $table->dropColumn('remote_relation_type_id');
        });
    }
};
