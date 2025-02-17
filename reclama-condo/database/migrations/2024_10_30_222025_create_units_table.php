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
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('block_id');
            $table->string('unit_number');
            $table->enum('status', ['occupied', 'vacant', 'reserved', 'in repair'])->default('vacant');
            $table->decimal('base_rent', 10, 2)->default(0.00);
            $table->unsignedInteger('tenant_id')->nullable();
            $table->timestamps();

            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
