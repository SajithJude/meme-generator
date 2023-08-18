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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->enum('plans',['weekly', 'monthly', 'yearly']);
            $table->double('discount_percentage');
            $table->integer('is_access_cource');
            $table->integer('duration');
            $table->integer('feedback_video_count');
            $table->enum('webinar_access',['1','0']);
            $table->enum('yoodli_access',['1','0']);
            $table->double('price');
            $table->timestamps();
         });
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
