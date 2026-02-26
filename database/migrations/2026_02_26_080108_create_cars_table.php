<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('color')->nullable();
            $table->string('plate_number')->unique();
            $table->integer('capacity')->nullable();
            $table->string('transmission')->nullable(); // e.g., Manual, Automatic
            $table->string('fuel_type')->nullable(); // e.g., Gas, Diesel, Electric
            $table->decimal('daily_rate', 10, 2);
            $table->text('description')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
