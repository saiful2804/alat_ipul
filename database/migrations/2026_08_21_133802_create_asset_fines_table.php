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
        Schema::create('asset_fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_return_id')->constrained()->cascadeOnDelete();
            $table->enum('type',['late','damage','lost']);
            $table->decimal('amount',12,2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_fines');
    }
};
