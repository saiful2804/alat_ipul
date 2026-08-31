<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets_status_enum', function (Blueprint $table) {
            DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM ('booked', 'borrowed', 'verifying', 'returned', 'cancelled') DEFAULT ('booked')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets_status_enum', function (Blueprint $table) {
            //
        });
    }
};
