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
        Schema::create('treasury_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('auto_serial');
            $table->string('trans_code');
            $table->integer('isal_number');
            $table->integer('admin_shift_id');
            $table->integer('treasury_id');
            $table->integer('mov_type_id');
            $table->integer('the_foregin_key')->nullable();
            $table->integer('account_id')->nullable();
            $table->tinyInteger('is_account')->default('0');
            $table->tinyInteger('is_approved');
            $table->decimal('money');
            $table->decimal('money_for_account');
            $table->date('mov_date');
            $table->string('byan')->nullable();
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
        Schema::dropIfExists('treasury_transactions');
    }
};
