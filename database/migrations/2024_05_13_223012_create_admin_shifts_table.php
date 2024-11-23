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
        Schema::create('admin_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('shift_code');
            $table->integer('admin_id');
            $table->integer('treasury_id');
            $table->decimal('treasury_balnce_in_shift_start');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->tinyInteger('is_finished')->default('0');
            $table->tinyInteger('is_delivered')->default('0');
            $table->integer('delivered_to_admin_id')->default('0');
            $table->integer('delivered_to_admin_shift_id')->default('0');
            $table->integer('delivered_to_treasury_id')->default('0');
            $table->decimal('money_should_deviled')->default('0');
            $table->decimal('what_realy_delivered')->default('0');
            $table->tinyInteger('money_state')->default('0');
            $table->decimal('money_state_value')->default('0');
            $table->tinyInteger('receive_type')->default('0');
            $table->dateTime('review_recevie_date')->nullable();
            $table->integer('treasury_transactions_id')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('admin_shifts');
    }
};
