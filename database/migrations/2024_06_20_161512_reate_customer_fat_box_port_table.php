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
        Schema::create('customer_fat_box_port', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('fat_box_id')->constrained()->onDelete('cascade');
            $table->foreignId('port_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['customer_id', 'fat_box_id', 'port_id'], 'unique_customer_fat_box_port');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_fat_box_port');
    }
};
