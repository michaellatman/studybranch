<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTask extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task', function(Blueprint $table)
		{
			$table->increments('task_id');
			$table->timestamps();
            $table->string('title');
            $table->dateTime('due_date');
            $table->unsignedInteger('user_id')->index("indx_user_id");
            $table->foreign('user_id')
                ->references('user_id')->on('user')
                ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task');
	}

}
