<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultColumnToOrganizationRole extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('organization__role', function(Blueprint $table)
		{
			//
            $table->boolean("default")->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('organization__role', function(Blueprint $table)
		{
			//
            $table->dropColumn("default");
		});
	}

}
