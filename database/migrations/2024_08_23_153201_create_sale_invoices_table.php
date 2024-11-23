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
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('auto_serial');
            $table->date('invoice_date');
            $table->integer('customer_id')->nullable();
            $table->tinyInteger('is_has_customer');
            $table->integer('account_number')->nullable();
            $table->integer('delegate_id');
            $table->integer('delegate_auto_invoice_number')->nullable();
            $table->integer('sales_matrial_type_id');
            $table->tinyInteger('is_approved')->default('0');
            $table->tinyInteger('discount_type')->nullable();
            $table->decimal('discount_percent')->default('0');
            $table->decimal('discount_value')->default('0');
            $table->decimal('tax_percent')->default('0');
            $table->decimal('tax_value')->default('0');
            $table->decimal('total_befor_discount')->default('0');
            $table->decimal('total_cost')->default('0');
            $table->decimal('total_cost_items')->default('0');
            $table->decimal('money_for_account')->default('0');
            $table->tinyInteger('pill_type');
            $table->decimal('what_paid')->default('0');
            $table->decimal('what_remain')->default('0');
            $table->integer('treasuries_transaction_id')->nullable();
            $table->decimal('customer_balance_befor')->nullable();
            $table->decimal('customer_balance_after')->nullable();
            $table->string('notes')->nullable();
            $table->tinyInteger('active')->default('1');
            $table->integer('approved_by')->nullable();
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->integer('com_code');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_invoices');
    }
};
