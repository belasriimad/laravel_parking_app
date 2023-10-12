<?php

use App\Models\Sector;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('hourly_price');
            $table->timestamps();
        });

        
        Sector::create(['name' => 'Top Sector', 'hourly_price' => 10]);
        Sector::create(['name' => 'Right Sector', 'hourly_price' => 20]);
        Sector::create(['name' => 'Left Sector', 'hourly_price' => 30]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};
