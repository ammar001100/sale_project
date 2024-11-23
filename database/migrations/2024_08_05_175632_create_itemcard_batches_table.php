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
        Schema::create('itemcard_batches', function (Blueprint $table) {
            $table->id();
            $table->integer('store_id');
            $table->integer('auto_serial');
            $table->integer('item_card_id');
            $table->integer('uom_id');
            $table->decimal('unit_cost_price');
            $table->decimal('quantity');
            $table->decimal('total_cost_price');
            $table->date('pro_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->integer('is_send_to_archived')->default(0);
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
        Schema::dropIfExists('itemcard_batches');
    }
};
