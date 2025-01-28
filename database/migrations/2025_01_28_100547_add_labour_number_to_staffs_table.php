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
        Schema::table('staffs', function (Blueprint $table) {
            $table->integer('labour_number')->nullable()->after('email');
        });

        Schema::table('staff_members', function (Blueprint $table) {
            $table->integer('labour_number')->nullable()->after('role');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staffs', function (Blueprint $table) {
            $table->dropColumn('labour_number');
        });

        Schema::table('staff_members', function (Blueprint $table) {
            $table->dropColumn('labour_number');
        });
    }
};
