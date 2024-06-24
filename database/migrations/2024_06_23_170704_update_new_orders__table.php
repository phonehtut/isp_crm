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
        Schema::table('new_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('township_id')->nullable()->after('lat_long');
            $table->unsignedBigInteger('fat_id')->nullable()->after('status');
            $table->unsignedBigInteger('port_id')->nullable()->after('status');
            $table->string('fat_optical')->nullable()->after('status');
            $table->string('cus_res_optical')->nullable()->after('status');
            $table->string('onu_optical')->nullable()->after('status');
            $table->string('cable_start')->nullable()->after('status');
            $table->string('cable_end')->nullable()->after('status');
            $table->string('total_cable')->nullable()->after('status');

            $table->foreign('township_id')->references('id')->on('townships');
            $table->foreign('fat_id')->references('id')->on('fat_boxes');
            $table->foreign('port_id')->references('id')->on('ports');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_orders', function (Blueprint $table) {
            // Dropping foreign key constraints with correct names
            $table->dropForeign(['township_id']);
            $table->dropForeign(['fat_id']);
            $table->dropForeign(['port_id']);

            // Dropping columns
            $table->dropColumn([
                'township_id',
                'fat_id',
                'port_id',
                'fat_optical',
                'cus_res_optical',
                'onu_optical',
                'cable_start',
                'cable_end',
                'total_cable'
            ]);
        });
    }
};
