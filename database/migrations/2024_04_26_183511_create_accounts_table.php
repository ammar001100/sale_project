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
        //جدول الشجرة المحاسبية العامة
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('account_type_id');
            $table->integer('account_id')->default('0');
            $table->integer('account_number');
            $table->decimal('start_balance'); //دائن او مدين او متزن اول المدة
            $table->tinyInteger('start_balance_status')->default('3'); // دائن-1 مدين-2 متزن-3
            $table->decimal('current_balance')->default('0');
            $table->tinyInteger('is_parent')->default('0');
            $table->integer('other_table_FK')->default('0');
            $table->string('notes')->nullable();
            $table->tinyInteger('is_archived')->default('0');
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
        Schema::dropIfExists('accounts');
    }
};
