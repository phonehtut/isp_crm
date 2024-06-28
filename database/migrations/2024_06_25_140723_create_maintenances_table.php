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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->dateTime('issues_at');
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->longText('cc_remark')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->longText('noc_remark')->nullable();
            $table->unsignedBigInteger('noc_engineer')->nullable();
            $table->unsignedBigInteger('finish_noc_engineer')->nullable();
            $table->enum('status', ['0','1', '2'])->default('2')->nullable();
            $table->enum('site_engineer', ['0','1'])->default('1')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->string('duration')->nullable();
            $table->longText('issues')->nullable();
            $table->unsignedBigInteger('fault_point_id')->nullable();
            $table->string('onu')->nullable();
            $table->string('adapter')->nullable();
            $table->string('drop_cable')->nullable();
            $table->string('patch_cord_apc')->nullable();
            $table->string('patch_cord_upc')->nullable();
            $table->string('pigtail_apc')->nullable();
            $table->string('pigtail_upc')->nullable();
            $table->string('sleeve')->nullable();
            $table->string('sleeve_closure')->nullable();
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('noc_engineer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('finish_noc_engineer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fault_point_id')->references('id')->on('fault_points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
