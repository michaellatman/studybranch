<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnUpdate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('task', function(Blueprint $table)
		{
			$table->dropForeign("task_user_id_foreign");
            $table->foreign('user_id')
                ->references('user_id')->on('user')
                ->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('task', function(Blueprint $table)
		{
			//
            $table->dropForeign("task_user_id_foreign");
            $table->foreign('user_id')
                ->references('user_id')->on('user')
                ->onDelete('cascade');
		});
	}

}
