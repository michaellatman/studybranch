<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrgId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('section', function(Blueprint $table)
		{
			//
            $table->unsignedInteger("organization_id");
            $table->foreign('organization_id')->references('organization_id')->on('organization')->onDelete("cascade")->onUpdate("cascade");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('section', function(Blueprint $table)
		{
			//
            $table->dropForeign("section_organization_id_foreign");
            $table->dropColumn("organization_id");

		});
	}

}
