<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('author');
            $table->foreign('author')->references('id')->on('users');
            $table->string('title');
            $table->enum('diet_style', ['ALLES', 'VEGETARISCH', 'VEGAN']);
            $table->enum('cuisine', ['DEUTSCH', 'MEDITERAN', 'ASIATISCH', 'AMERIKANISCH', 'INDISCH']);
            $table->integer('time_to_prepare');
            $table->json('ingredients');
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
        Schema::dropIfExists('recipes');
    }
}
