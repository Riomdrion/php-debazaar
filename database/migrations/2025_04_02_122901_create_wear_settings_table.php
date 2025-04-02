<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wear_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verhuur_advertentie_id')->constrained()->onDelete('cascade');

            $table->decimal('slijtage_per_dag', 5, 2)->default(1.0); // bijv. 1.0%
            $table->decimal('slijtage_per_verhuur', 5, 2)->default(2.0); // bijv. 2.0%
            $table->decimal('categorie_modifier', 5, 2)->default(1.0); // bijv. 1.5 = 50% meer slijtage

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wear_settings');
    }
};
