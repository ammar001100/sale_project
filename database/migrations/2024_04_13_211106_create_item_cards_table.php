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
        Schema::create('item_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('barcode');
            $table->string('item_code');
            $table->integer('item_type');
            $table->integer('itemcard_category_id');
            $table->integer('item_card_id')->default(0);
            $table->integer('does_has_retailunit');
            $table->integer('retail_uom_id')->default(0);
            $table->integer('uom_id');
            $table->decimal('retail_uom_quntToparent')->default(0);
            $table->decimal('price');
            $table->decimal('nos_gomal_price');
            $table->decimal('gomal_price');
            $table->decimal('price_retail')->default(0);
            $table->decimal('nos_gomal_price_retail')->default(0);
            $table->decimal('gomal_price_retail')->default(0);
            $table->decimal('cost_price');
            $table->decimal('cost_price_retail')->default(0);
            $table->integer('has_fixced_price');
            $table->decimal('quentity')->default(0);
            $table->decimal('all_quentity')->default(0);
            $table->decimal('quentity_retail')->default(0);
            $table->decimal('quentity_all_retails')->default(0);
            $table->string('photo')->default('default.png');
            $table->integer('active')->default('1');
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
        Schema::dropIfExists('item_cards');
    }
};
