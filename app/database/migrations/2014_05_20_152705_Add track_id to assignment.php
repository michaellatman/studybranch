<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackIdToAssignment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assignment', function(Blueprint $table)
		{
			//
            $table->unsignedInteger("track_id");
            $table->foreign('track_id')->references('track_id')->on('track')->onDelete("cascade")->onUpdate("cascade");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assignment', function(Blueprint $table)
		{
			//
            $table->dropForeign("assignment_track_id_foreign");
            $table->dropColumn("track_id");
		});
	}

}
