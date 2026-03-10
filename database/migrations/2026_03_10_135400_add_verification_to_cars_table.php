<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('or_file')->nullable()->after('image');
            $table->string('cr_file')->nullable()->after('or_file');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('cr_file');
            $table->text('rejection_reason')->nullable()->after('verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['or_file', 'cr_file', 'verification_status', 'rejection_reason']);
        });
    }
};
