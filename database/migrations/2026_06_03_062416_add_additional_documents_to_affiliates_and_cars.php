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
        Schema::table('affiliate_details', function (Blueprint $table) {
            $table->string('owner_id_1')->nullable()->after('vehicles_submitted');
            $table->string('owner_id_2')->nullable()->after('owner_id_1');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->string('comprehensive_insurance')->nullable()->after('cr_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_details', function (Blueprint $table) {
            $table->dropColumn(['owner_id_1', 'owner_id_2']);
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('comprehensive_insurance');
        });
    }
};
