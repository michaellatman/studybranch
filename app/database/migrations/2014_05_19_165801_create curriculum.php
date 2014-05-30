<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculum extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track', function(Blueprint $table)
        {
            $table->increments('track_id');
            $table->string("name");
            $table->string("description",1000);
            $table->unsignedInteger("organization_id");
            $table->timestamps();
        });
        //Schema::drop('class');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('track');
    }

}
