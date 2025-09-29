<?php

// database/migrations/xxxx_xx_xx_create_plans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Freemium, Standard, Pro
            $table->decimal('prix_mensuel', 10, 2)->default(0);
            $table->decimal('prix_annuel', 10, 2)->default(0);
            $table->integer('nb_evenements_max')->default(1); // -1 = illimité
            $table->integer('nb_services_max')->default(5); // -1 = illimité
            $table->boolean('export_pdf')->default(false);
            $table->boolean('multi_users')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('plans');
    }
};

