<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('Tirada_Uno');
            $table->integer('Tirada_Dos');
            $table->boolean('Derrota_Victoria');
            $table->foreignId('users_id')
                    ->constrained('users')->OnDelete('cascade');                   
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
