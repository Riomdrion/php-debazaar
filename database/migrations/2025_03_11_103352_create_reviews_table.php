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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->morphs('reviewable'); // kan advertentie of gebruiker zijn
            $table->foreignId('user_id')->constrained(); // reviewer
            $table->foreignId('bedrijf_id')->constrained("bedrijfs"); // reviewer
            $table->foreignId('advertentie_id')->constrained("advertensies"); // reviewer
            $table->foreignId('verhuuradvertentie_id')->constrained("verhuuradvertenties"); // reviewer
            $table->integer('rating');
            $table->text('bericht')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
