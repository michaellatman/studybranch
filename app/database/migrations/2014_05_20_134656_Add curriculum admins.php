<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurriculumAdmins extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('track__admin', function(Blueprint $table)
		{
			$table->increments('track__admin_id');
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
        Schema::table("track__admin",function (Blueprint $table){
            $table->dropForeign("track__admin_track_id_foreign");
            $table->dropForeign("track__admin_user_id_foreign");
        });
		Schema::drop('track__admin');
	}

}
