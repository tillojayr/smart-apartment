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
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('reminder_time')->nullable();
            $table->string('address')->nullable();
            $table->smallInteger('flag')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('contact_number');
            $table->dropColumn('email');
            $table->dropColumn('reminder_time');
            $table->dropColumn('address');
            $table->dropColumn('flag');
        });
    }
};
