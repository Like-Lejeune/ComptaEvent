<?php

// database/migrations/xxxx_xx_xx_create_abonnements_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['actif','expiré','en_attente'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('abonnements');
    }
};
