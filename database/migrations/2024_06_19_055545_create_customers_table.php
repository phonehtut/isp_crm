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
            $table->string('name');
            $table->string('customer_id')->nullable();
            $table->date('register_date')->nullable();
            $table->string('sn')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone');
            $table->longText('address');
            $table->string('nrc_front')->nullable();
            $table->string('nrc_back')->nullable();
            $table->string('lat_long')->nullable();
            $table->enum('status', ["0","1"])->default('0')->comment('0: pending , 1: finish');
            $table->string('start_cable')->nullable();
            $table->string('end_cable')->nullable();
            $table->string('total_cable')->nullable();
            $table->string('fat_optical')->nullable();
            $table->string('cus_res_optical')->nullable();
            $table->string('onu_optical')->nullable();
            $table->string('create_user')->nullable();
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
