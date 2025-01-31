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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('room_number')->nullable();
            $table->string('tenant');
            $table->timestamp('joined_at');
            $table->string('password');
            $table->integer('bill')->nullable();
            $table->integer('volts')->nullable();
            $table->decimal('current', 8, 2)->nullable();
            $table->decimal('consumed', 10, 2)->nullable();
            $table->string('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
