<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserEmailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user__email', function(Blueprint $table)
		{
			$table->increments('email_id');
			$table->unsignedInteger("user_id");
            $table->string("email");
            $table->foreign('user_id')->references('user_id')->on('user')->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('user__email', function(Blueprint $table) {
            $table->dropForeign("user__email_user_id_foreign");
        });
		Schema::drop('user__email');
	}

}
