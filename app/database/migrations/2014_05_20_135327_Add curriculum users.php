<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurriculumUsers extends Migration {


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track__user', function(Blueprint $table)
        {
            $table->increments('track__user_id');
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("track_id");
            $table->timestamps();
            $table->foreign('track_id')->references('track_id')->on('track')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('user_id')->references('user_id')->on('user')->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("track__user",function (Blueprint $table){
            $table->dropForeign("track__user_track_id_foreign");
            $table->dropForeign("track__user_user_id_foreign");
        });
        Schema::drop('track__user');
    }
}
