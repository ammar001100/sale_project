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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');
            $table->string('photo')->default('default.png');
            $table->integer('active');
            $table->string('general_alert')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->integer('added_by')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
};
