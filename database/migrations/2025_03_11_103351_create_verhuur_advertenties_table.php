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
        Schema::create('verhuur_advertenties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('titel');
            $table->text('beschrijving');
            $table->decimal('dagprijs', 8, 2);
            $table->decimal('borg', 8, 2);
            $table->boolean('is_actief')->default(true);
            $table->string('qr_code')->nullable();
            $table->integer('vervangingswaarde')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verhuur_advertenties');
    }
};
