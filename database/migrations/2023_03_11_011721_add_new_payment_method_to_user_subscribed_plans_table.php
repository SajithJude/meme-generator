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
        Schema::table('user_subscribed_plans', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_subscribed_plans MODIFY COLUMN paid_with ENUM('credit_card', 'paypal', 'bank_transfer', 'stripe', 'cash', 'manual')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscribed_plans', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_subscribed_plans MODIFY COLUMN paid_with ENUM('credit_card', 'paypal')");
        });
    }
};
