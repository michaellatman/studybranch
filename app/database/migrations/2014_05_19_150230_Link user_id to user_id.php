<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkUserIdToUserId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user__activation_codes', function(Blueprint $table)
		{
			//
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
		Schema::table('user__activation_codes', function(Blueprint $table)
		{
			//
            $table->dropForeign("user__activation_codes_user_id_foreign");
		});
	}

}
