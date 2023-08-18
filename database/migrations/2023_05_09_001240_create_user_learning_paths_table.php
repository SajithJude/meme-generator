<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_learning_paths', function (Blueprint $table) {
            $table->id();
            $table->integer('first_course_id');
            $table->integer('second_course_id');
            $table->date('date')->format('Y-m');
            $table->foreignIdFor(User::class);
            $table->timestamps();
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_learning_paths');
    }
};
