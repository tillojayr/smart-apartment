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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('bill')->nullable();
            $table->integer('volts')->nullable();
            $table->decimal('current', 8, 2)->nullable();
            $table->decimal('consumed', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bill');
            $table->dropColumn('volts');
            $table->dropColumn('current');
            $table->dropColumn('consumed');
        });
    }
};
