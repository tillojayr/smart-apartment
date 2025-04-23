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
            $table->integer('budget')->default(0)->nullable();
            $table->string('budget_notification_flag1')->default(0)->nullable();
            $table->string('budget_notification_flag2')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('budget');
            $table->dropColumn('budget_notification_flag1');
            $table->dropColumn('budget_notification_flag2');
        });
    }
};
