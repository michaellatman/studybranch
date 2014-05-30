<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToActivationCodesAndAddEmailField extends Migration {

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
            $table->timestamps();
            $table->string("email");
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
            $table->dropTimestamps();
            $table->dropColumn("email");
		});
	}

}
