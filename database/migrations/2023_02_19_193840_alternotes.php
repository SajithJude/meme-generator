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
        Schema::table('user_notes', function (Blueprint $table) {
            //$table->text('notes')->nullable();
            $table->datetime('last_played')->nullable();
            $table->datetime('completed_at')->nullable();
        });
        \DB::query("ALTER TABLE `user_notes` CHANGE COLUMN `user_notes` `user_notes` text();");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
