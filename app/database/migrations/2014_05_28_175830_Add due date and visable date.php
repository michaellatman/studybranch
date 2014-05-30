<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDueDateAndVisableDate extends Migration {

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
            $table->dateTime("due_date");
            $table->dateTime("visible_date");
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
            $table->dropColumn("due_date");
            $table->dropColumn("visible_date");
		});
	}

}
