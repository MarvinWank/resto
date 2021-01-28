<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecipeAddColumnTotalTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->renameColumn('diet_style', 'dietStyle');
            $table->renameColumn('time_to_prepare', 'timeToPrepare');
            $table->integer("totalTime");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->renameColumn('dietStlye', 'diet_style');
            $table->renameColumn('timeToPrepare', 'time_to_prepare');
            $table->dropColumn("total_time");
        });
    }
}
