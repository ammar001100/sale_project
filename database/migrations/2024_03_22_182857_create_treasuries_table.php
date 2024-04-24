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
        Schema::create('treasuries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('is_master')->default('0');
            $table->integer('last_isal_exhcange'); //رقم اخر اصال صرف
            $table->integer('last_isal_collect'); // رقم اخر اصال تحصيل
            $table->integer('active')->default('1');
            $table->integer('com_code');
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasuries');
    }
};
