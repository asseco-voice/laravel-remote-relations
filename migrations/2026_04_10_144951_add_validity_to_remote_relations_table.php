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
            $table->date('valid_from')->nullable()->after('remote_relation_type_id');
            $table->date('valid_to')->nullable()->after('valid_from');
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
            $table->dropColumn(['valid_from', 'valid_to']);
        });
    }
};
