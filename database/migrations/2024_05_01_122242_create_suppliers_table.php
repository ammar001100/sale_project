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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('supplier_code');
            $table->integer('supplier_category_id');
            $table->string('photo')->default('default.png');
            $table->string('address')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('phone')->nullable();
            $table->integer('account_number');
            $table->decimal('start_balance'); //دائن او مدين او متزن اول المدة
            $table->tinyInteger('start_balance_status')->default('3'); // دائن-1 مدين-2 متزن-3
            $table->decimal('current_balance')->default('0');
            $table->string('notes')->nullable();
            $table->tinyInteger('active')->default('1');
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
        Schema::dropIfExists('suppliers');
    }
};
