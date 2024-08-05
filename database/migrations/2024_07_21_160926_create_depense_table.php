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
        Schema::create('depense', function (Blueprint $table) {
            $table->id('id_depense');
            $table->unsignedBigInteger('service_id');
            $table->string('d_name', 60)->default("");
            $table->unsignedBigInteger('user_id');
            $table->text('d_description')->default("");
            $table->bigInteger('s_depense', false)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depense');
    }
};
