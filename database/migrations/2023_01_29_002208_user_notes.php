<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('user_notes')) {
            Schema::create('user_notes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('lesson_id');
                $table->integer('user_id');
                $table->longText('notes');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('user_notes', function (Blueprint $table) {
            //
        });
    }
};
