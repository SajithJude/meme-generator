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
        Schema::create('user_subscribed_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->double('price')->comment('price of the subscription paid by customer');
            $table->timestamp('subscription_start_date')->comment('datetime when customer subscribes');
            $table->timestamp('subscription_end_date')->comment('datetime when customer subscription ends')->nullable();
            $table->enum('paid_with', ['credit_card', 'paypal'])->default('credit_card');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_subscribed_plans');
    }
};
