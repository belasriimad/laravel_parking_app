<?php

use App\Models\Place;
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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('availlable')->default(1);
            $table->foreignId('sector_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('total_price')->nullable();
            $table->timestamps();
        });
        
        for ($i=1; $i<=20; $i++) {
            Place::create(['name' => 'place '.$i, 'sector_id' => rand(1,3)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
