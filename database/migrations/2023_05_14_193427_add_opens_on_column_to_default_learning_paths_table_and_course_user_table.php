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
        Schema::table('default_learning_paths', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->integer('opens_on')->after('id');
        });

        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn('opened_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('default_learning_paths', function (Blueprint $table) {
            $table->dropColumn('opens_on');
            $table->date('date')->after('id');
        });

        Schema::table('course_user', function (Blueprint $table) {
            $table->date('opened_at')->after('user_id');
        });
    }
};
