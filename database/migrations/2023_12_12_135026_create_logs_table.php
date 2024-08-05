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
        Schema::create('logs', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('projet_id')->nullable();
            $table->unsignedBigInteger('intervenant_id');
            $table->string('methode');
            $table->string('fonction');
            $table->string('url');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('occurrence'); // Champ "occurrence" ajouté
            $table->date('jour');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
