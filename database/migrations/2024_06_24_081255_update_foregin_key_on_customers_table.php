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
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('township_id')->nullable()->after('lat_long');
            $table->foreign('township_id')->references('id')->on('townships')->onDelete('cascade');
            $table->unsignedBigInteger('plan_id')->nullable()->after('nrc_back');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->unsignedBigInteger('fat_id')->nullable()->after('onu_optical');
            $table->foreign('fat_id')->references('id')->on('fat_boxes')->onDelete('cascade');
            $table->unsignedBigInteger('port_id')->nullable()->after('fat_id');
            $table->foreign('port_id')->references('id')->on('ports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
