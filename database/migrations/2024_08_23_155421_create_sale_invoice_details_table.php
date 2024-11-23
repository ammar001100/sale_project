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
        Schema::create('sale_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_invoice_id');
            $table->integer('item_card_id');
            $table->tinyInteger('sale_item_type');
            $table->integer('batch_id')->nullable();
            //$table->tinyInteger('order_type');
            $table->decimal('quantity');
            $table->integer('uom_id');
            $table->tinyInteger('is_master_uom');
            $table->tinyInteger('is_bounce_or_other')->default(0);
            $table->decimal('unit_price');
            $table->decimal('total_price');
            $table->date('invoice_date');
            $table->date('pro_date')->nullable();
            $table->date('ex_date')->nullable();
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
        Schema::dropIfExists('sale_invoice_details');
    }
};
