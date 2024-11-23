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
        Schema::create('mov_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('system_id');
            $table->tinyInteger('in_screen');
            $table->tinyInteger('is_private_intemal');
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
        Schema::dropIfExists('mov_types');
    }
};
