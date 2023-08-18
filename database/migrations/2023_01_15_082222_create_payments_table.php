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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->double('price')->comment('price of the subscription paid by customer');
            $table->string('exp_month')->comment('expiry month of the card used by customer');
            $table->string('exp_year');
            $table->string('card_number');
            $table->string('card_name')->nullable();
            $table->string('card_type')->nullable();
            $table->string('intent_id');
            $table->string('payment_method_id');
            $table->string('receipt_url')->nullable();
            $table->longText('gateway_response')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
