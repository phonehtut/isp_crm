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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('mainten_image');
            $table->longText('install-image');
            $table->longText('reason')->nullable();
            $table->enum('priority', ["0","1","2","3"])->default('0')->comment('low , middle , high , ugent');
            $table->enum('status', ["0","1","2"])->default('0')->comment('open , resolved , close');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
