<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('transaction_amount');
            $table->integer('installments');
            $table->string('token')->unique();
            $table->string('payment_method_id');
            $table->string('payer_entity_type')->default('individual');
            $table->string('payer_type')->default('customer');
            $table->string('payer_email');
            $table->string('payer_identification_type')->default('cpf');
            $table->string('payer_identification_number');
            $table->string('notification_url');
            $table->date('created_at');
            $table->date('updated_at');
            $table->enum('status', ['pending', 'paid', 'canceled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('payments');
    }
};
