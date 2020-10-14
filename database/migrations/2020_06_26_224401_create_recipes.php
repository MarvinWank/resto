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
            $table->enum('diet_style', ['fleischhaltig', 'vegetarisch', 'vegan']);
            $table->enum('cuisine', ['deutsch', 'mediteran', 'asiatisch', 'amerikanisch', 'indisch']);
            $table->integer('time_to_prepare');
            $table->integer('kcal');
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
