<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkCredentialUserIdToUserId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user__credential', function(Blueprint $table)
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
		Schema::table('user__credential', function(Blueprint $table)
		{
			//
            $table->dropForeign("user__credential_user_id_foreign");
		});
	}

}
