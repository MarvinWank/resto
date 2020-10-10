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
            $table->enum('type_of_meal', ['fruehstück', 'mittagessen', 'abendbrot', 'snack']);
            $table->enum('meat_contents', ['fleischhaltig', 'vegetarisch', 'vegan']);
            $table->enum('cuisine', ['deutsch', 'mediteran', 'asiatisch', 'amerikanisch', 'indisch']);
            $table->json('uses_ingredients');
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
