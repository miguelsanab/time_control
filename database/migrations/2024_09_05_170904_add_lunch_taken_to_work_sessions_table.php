<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLunchTakenToWorkSessionsTable extends Migration

{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('work_sessions', function (Blueprint $table) {
            $table->boolean('lunch_taken')->default(false);
        });
    }

    public function down()
    {
        Schema::table('work_sessions', function (Blueprint $table) {
            $table->dropColumn('lunch_taken');
});
}
};
