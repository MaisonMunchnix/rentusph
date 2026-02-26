<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameRoleAffiliatedToAffiliate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Add 'affiliate' to the enum, keeping 'affiliated' temporarily
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'affiliate', 'affiliated', 'customer') DEFAULT 'customer'");
        
        // 2. Update existing 'affiliated' records to 'affiliate'
        DB::table('users')->where('role', 'affiliated')->update(['role' => 'affiliate']);
        
        // 3. Remove 'affiliated' from the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'affiliate', 'customer') DEFAULT 'customer'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'affiliate', 'affiliated', 'customer') DEFAULT 'customer'");
        DB::table('users')->where('role', 'affiliate')->update(['role' => 'affiliated']);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'affiliated', 'customer') DEFAULT 'customer'");
    }
}
