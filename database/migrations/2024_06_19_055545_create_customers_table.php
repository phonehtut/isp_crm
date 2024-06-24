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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->unsignedBigInteger('name');
            $table->foreign('name')->references('id')->on('new_orders')->onDelete('cascade');
            $table->string('township')->nullable();
            $table->date('register_date')->nullable();
            $table->unsignedBigInteger('fat_id')->nullable();
            $table->foreign('fat_id')->references('id')->on('fat_boxes')->onDelete('cascade');
            $table->unsignedBigInteger('port_id')->nullable();
            $table->foreign('port_id')->references('id')->on('ports')->onDelete('cascade');
            $table->string('sn')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
