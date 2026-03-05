<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('rental_amount', 12, 2)->nullable()->after('total_price');
            $table->decimal('security_deposit', 12, 2)->nullable()->after('rental_amount');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['rental_amount', 'security_deposit']);
        });
    }
};
