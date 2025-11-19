<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id_service');
            $table->unsignedBigInteger('evenement_id')->nullable();// FK → evenements.id
            $table->string('s_name');
            $table->text('s_description')->default("");
            $table->bigInteger('s_budget', false)->default(0);
            $table->bigInteger('s_solde', false)->default(0);
            $table->text('s_photo')->default("");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(null);
            
               // clé étrangère vers evenements
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
