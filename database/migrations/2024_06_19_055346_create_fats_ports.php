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
        Schema::create('fats_ports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fat_id');
            $table->foreign('fat_id')->references('id')->on('fat_boxes')->onDelete('cascade');
            $table->unsignedBigInteger('port_id');
            $table->foreign('port_id')->references('id')->on('ports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fats_ports');
    }
};
