<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('familia_tutor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('familias_profesionales_id')->constrained('familias_profesionales')->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained('tutores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('familia_tutor');
    }
};
