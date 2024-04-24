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
        Schema::create('treasuries_deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('treasuries_id'); // الخزنه التي سوف تستلم
            $table->integer('treasuries_can_delivery_id'); //الخزنة التي سوف يتم تسليمها
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
        Schema::dropIfExists('treasuries_deliveries');
    }
};
