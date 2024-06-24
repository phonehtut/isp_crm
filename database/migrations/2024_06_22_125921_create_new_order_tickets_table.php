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
        Schema::create('new_order_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('new_order_id')->nullable();
            $table->foreign('new_order_id')->references('id')->on('new_orders')->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->longText('reason')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('fat_optical')->nullable();
            $table->string('onu_optical')->nullable();
            $table->enum('priority', ["0","1","2","3"])->default('0')->comment('low , middle , high , ugent');
            $table->enum('status', ["0","1","2"])->default('0')->comment('open , resolved , close');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_order_tickets');
    }
};
