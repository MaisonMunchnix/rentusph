<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->nullable()->after('security_deposit');
            $table->decimal('platform_commission', 12, 2)->nullable()->after('commission_rate');
            $table->decimal('affiliate_earnings', 12, 2)->nullable()->after('platform_commission');
            $table->decimal('deposit_deducted', 12, 2)->default(0)->after('affiliate_earnings');
            $table->decimal('deposit_refunded', 12, 2)->nullable()->after('deposit_deducted');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'commission_rate',
                'platform_commission',
                'affiliate_earnings',
                'deposit_deducted',
                'deposit_refunded'
            ]);
        });
    }
};
