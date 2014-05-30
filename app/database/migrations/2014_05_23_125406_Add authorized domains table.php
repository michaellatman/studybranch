<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorizedDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organization__domain', function(Blueprint $table)
		{
			$table->increments('domain_id');
            $table->string("domain");
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
        Schema::table('organization__domain', function(Blueprint $table) {
            $table->dropForeign("organization__domain_organization_id_foreign");
        });
		Schema::drop('organization__domain');
	}

}
