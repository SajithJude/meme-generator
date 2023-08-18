<?php

use App\Models\Course;
use App\Models\User;
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
        Schema::table('user_learning_paths', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropIndex('user_learning_paths_user_id_date_unique');
        });

        Schema::rename('user_learning_paths', 'default_learning_paths');
        Schema::table('default_learning_paths', function (Blueprint $table) {
            $table->dropColumn(['first_course_id', 'second_course_id']);
            $table->foreignIdFor(Course::class)->unique();
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
            $table->dropColumn('course_id');
        });

        Schema::rename('default_learning_paths', 'user_learning_paths');
        Schema::table('user_learning_paths', function (Blueprint $table) {
            $table->integer('first_course_id');
            $table->integer('second_course_id');
            $table->foreignIdFor(User::class);
            $table->unique(['user_id', 'date']);
        });


    }
};
