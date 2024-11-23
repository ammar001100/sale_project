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
        Schema::create('supplier_with_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_with_order_id');
            $table->integer('item_card_id');
            $table->tinyInteger('item_type');
            $table->integer('batch_id')->nullable();
            $table->tinyInteger('order_type');
            $table->decimal('deliverd_quantity');
            $table->integer('uom_id');
            $table->tinyInteger('is_master_uom');
            $table->decimal('unit_price');
            $table->decimal('total_price');
            $table->date('order_date');
            $table->date('pro_date')->nullable();
            $table->date('ex_date')->nullable();
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->integer('com_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_with_order_details');
    }
};
