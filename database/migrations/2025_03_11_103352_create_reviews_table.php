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

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // wie schrijft de review

            // Doelen van de review (slechts één wordt gebruikt per record)
            $table->foreignId('advertentie_id')->nullable()->constrained('advertenties')->onDelete('cascade');
            $table->foreignId('verhuur_advertentie_id')->nullable()->constrained('verhuur_advertenties')->onDelete('cascade');
            $table->foreignId('bedrijf_id')->nullable()->constrained('bedrijfs')->onDelete('cascade');

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
