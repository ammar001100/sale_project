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
        Schema::create('itemcard_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('itemcard_movement_category_id');
            $table->integer('itemcard_movement_type_id');
            $table->integer('item_card_id');
            $table->integer('store_id');
            $table->integer('FK_table');
            $table->integer('FK_table_details');
            $table->string('byan');
            $table->string('quantity_befor_move');
            $table->string('quantity_befor_move_store');
            $table->string('quantity_after_move');
            $table->string('quantity_after_move_store');
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
        Schema::dropIfExists('itemcard_movements');
    }
};
