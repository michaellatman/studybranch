<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentSection extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignment__section', function(Blueprint $table)
		{
            $table->increments('assignment__section_id');
            $table->unsignedInteger("track_id");
            $table->unsignedInteger("assignment_id");
            $table->foreign('track_id')->references('track_id')->on('track')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('assignment_id')->references('assignment_id')->on('assignment')->onDelete("cascade")->onUpdate("cascade");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('assignment__section', function(Blueprint $table) {
            $table->dropForeign("assignment__section_track_id_foreign");
            $table->dropForeign("assignment__section_assignment_id_foreign");
        });
		Schema::drop('assignment__section');
	}

}
