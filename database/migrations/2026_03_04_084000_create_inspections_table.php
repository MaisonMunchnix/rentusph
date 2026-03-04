<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('booking_id')->constrained()->onDelete('cascade');
            $blueprint->enum('condition', ['good', 'damaged'])->default('good');
            $blueprint->text('notes')->nullable();
            $blueprint->string('photos')->nullable(); // Store as JSON or comma-separated
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
