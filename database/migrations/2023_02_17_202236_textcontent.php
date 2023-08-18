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
        Schema::create('TextContent', function(Blueprint $table)
        {
            $table->id();
            $table->enum('type', ['TC', 'CP', 'PP']);
            $table->string('title', 100)->nullable();           
            $table->text('contenttext')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TextContent');
    }
};
