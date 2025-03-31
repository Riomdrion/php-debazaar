<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advertentie_koppelingen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertentie_id')->constrained()->onDelete('cascade');
            $table->foreignId('gekoppeld_id')->constrained('advertenties')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['advertentie_id', 'gekoppeld_id']); // voorkom dubbele koppelingen
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertentie_koppelingen');
    }
};
