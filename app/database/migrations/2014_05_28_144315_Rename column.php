<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('assignment__section', function(Blueprint $table) {
            $table->dropForeign("assignment__section_track_id_foreign");
        });
		Schema::table('assignment__section', function(Blueprint $table)
		{
            $table->renameColumn("track_id","section_id");
            $table->foreign('section_id')->references('section_id')->on('section')->onDelete("cascade")->onUpdate("cascade");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('assignment__section', function(Blueprint $table)
		{
            $table->dropForeign('assignment__section_section_id_foreign');
            $table->renameColumn("section_id","track_id");
            $table->foreign('track_id')->references('track_id')->on('track')->onDelete("cascade")->onUpdate("cascade");
			//
		});
	}

}
