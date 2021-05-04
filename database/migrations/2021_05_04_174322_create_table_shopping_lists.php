<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableShoppingLists extends Migration
{

    private const TABLE_NAME = 'shopping_lists';

    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            //Foreign key constraint to id of the shopping lists owner
            $table->bigInteger("user_id");
            $table->foreign("user_id")->references('id')->on('users');
            $table->json('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
