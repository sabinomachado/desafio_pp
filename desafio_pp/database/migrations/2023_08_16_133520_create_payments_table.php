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
            $table->string('bankSlipUrl')->nullable();
            $table->string('billingType');
            $table->string('customer');
            $table->decimal('value', 8, 2);
            $table->string('invoiceNumber')->nullable();
            $table->string('invoiceUrl')->nullable();
            $table->string('paymentId')->unique();
            $table->string('paymentLink')->nullable();
            $table->string('status')->default('PENDENTE');
            $table->string('transactionReceiptUrl')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
