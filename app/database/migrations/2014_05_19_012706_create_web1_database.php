<?php
 
//
// NOTE Migration Created: 2014-05-19 01:27:06
// --------------------------------------------------
 
class CreateWeb1Database {
//
// NOTE - Make changes to the database.
// --------------------------------------------------
 
public function up()
{

//
// NOTE -- announcement
// --------------------------------------------------
 
Schema::create('announcement', function($table) {
 $table->increments('announcement_id');
 $table->string('title', 45)->nullable();
 $table->text('body')->nullable();
 $table->unsignedInteger('owner')->nullable();
 $table->unsignedInteger('imageable_id');
 $table->string('imageable_type', 50);
 $table->unsignedInteger('approved')->nullable();
 $table->dateTime('updated_at');
 $table->dateTime('created_at');
 });


//
// NOTE -- group
// --------------------------------------------------
 
Schema::create('group', function($table) {
 $table->increments('group_id');
 $table->string('name', 50);
 $table->string('description', 255);
 $table->dateTime('created_at');
 $table->dateTime('updated_at');
 $table->unsignedInteger('organization_id');
 });


//
// NOTE -- group__user
// --------------------------------------------------
 
Schema::create('group__user', function($table) {
 $table->increments('group_user_id');
 $table->unsignedInteger('group_id');
 $table->unsignedInteger('user_id');
 });


//
// NOTE -- lookup__entity
// --------------------------------------------------
 
Schema::create('lookup__entity', function($table) {
 $table->increments('entity_id');
 $table->string('name', 45);
 });


//
// NOTE -- lookup__permissions
// --------------------------------------------------
 
Schema::create('lookup__permissions', function($table) {
 $table->increments('permission_id');
 $table->string('name', 30);
 $table->string('description', 300);
 });


//
// NOTE -- organization
// --------------------------------------------------
 
Schema::create('organization', function($table) {
 $table->increments('organization_id');
 $table->string('name', 30);
 $table->dateTime('created_at');
 $table->dateTime('updated_at');
 });


//
// NOTE -- organization__role
// --------------------------------------------------
 
Schema::create('organization__role', function($table) {
 $table->increments('role_id');
 $table->string('name', 45);
 $table->string('description', 45);
 $table->unsignedInteger('organization_id');
 });


//
// NOTE -- organization__role_permission
// --------------------------------------------------
 
Schema::create('organization__role_permission', function($table) {
 $table->increments('id');
 $table->unsignedInteger('role_id');
 $table->unsignedInteger('permission_id');
 });


//
// NOTE -- organization__role_user
// --------------------------------------------------
 
Schema::create('organization__role_user', function($table) {
 $table->increments('id');
 $table->unsignedInteger('role_id');
 $table->unsignedInteger('user_id');
 });


//
// NOTE -- organization__user
// --------------------------------------------------
 
Schema::create('organization__user', function($table) {
 $table->unsignedInteger('organization_id');
 $table->unsignedInteger('user_id');
 });


//
// NOTE -- user
// --------------------------------------------------
 
Schema::create('user', function($table) {
 $table->increments('user_id');
 $table->string("first_name");
 $table->string("last_name");
 $table->text('bio');
 $table->date('birthdate');
 $table->dateTime('created_at');
 $table->dateTime('updated_at');
 $table->boolean('activated');
 });


//
// NOTE -- user__activation_codes
// --------------------------------------------------
 
Schema::create('user__activation_codes', function($table) {
 $table->increments('code_id');
 $table->string('code', 45);
 $table->unsignedInteger('user_id');
 });


//
// NOTE -- user__address
// --------------------------------------------------
 
Schema::create('user__address', function($table) {
 $table->increments('address_id');
 $table->string('street', 45);
 $table->string('city', 45);
 $table->string('state', 45);
 $table->unsignedInteger('zip');
 $table->unsignedInteger('user_id');
 });


//
// NOTE -- user__credential
// --------------------------------------------------
 
Schema::create('user__credential', function($table) {
 $table->increments('credential_id');
 $table->unsignedInteger('user_id')->unique();
 $table->string('username', 45);
 $table->string('email', 30);
 $table->string('password');
 $table->string('remember_token', 255);
 });


//
// NOTE -- user__phone
// --------------------------------------------------
 
Schema::create('user__phone', function($table) {
 $table->increments('phone_id');
 $table->string('phone_number', 20);
 $table->unsignedInteger('user_id');
 });


//
// NOTE -- user__social
// --------------------------------------------------
 
Schema::create('user__social', function($table) {
 $table->increments('social_id');
 $table->unsignedInteger('user_id');
 $table->string('social_type', 45);
 $table->string('social_token', 1000);
 $table->string('social_refresh', 45);
 });


//
// NOTE -- user__token
// --------------------------------------------------
 
Schema::create('user__token', function($table) {
 $table->increments('token_id');
 $table->string('access_key', 60);
 $table->unsignedInteger('user_id');
 $table->dateTime('updated_at');
 $table->dateTime('created_at');
 $table->dateTime('expire_at');
 });



//
// NOTE -- announcement_foreign
// --------------------------------------------------

    Schema::table('announcement', function($table) {
        $table->foreign('owner')->references('user_id')->on('user')->onDelete("cascade")->onUpdate("cascade");
    });


//
// NOTE -- group_foreign
// --------------------------------------------------

    Schema::table('group', function($table) {
        $table->foreign('organization_id')->references('organization_id')->on('organization')->onDelete("cascade")->onUpdate("cascade");
    });


//
// NOTE -- group__user_foreign
// --------------------------------------------------

    Schema::table('group__user', function($table) {
        $table->foreign('user_id')->references('user_id')->on('user')->onDelete("cascade")->onUpdate("cascade");
        $table->foreign('group_id')->references('group_id')->on('group')->onDelete("cascade")->onUpdate("cascade");
    });


//
// NOTE -- organization__role_foreign
// --------------------------------------------------

    Schema::table('organization__role', function($table) {
        $table->foreign('organization_id')->references('organization_id')->on('organization')->onDelete("cascade")->onUpdate("cascade");
    });


//
// NOTE -- organization__role_permission_foreign
// --------------------------------------------------

    Schema::table('organization__role_permission', function($table) {
        $table->foreign('permission_id')->references('permission_id')->on('lookup__permissions')->onDelete("cascade")->onUpdate("cascade");
        $table->foreign('role_id')->references('role_id')->on('organization__role')->onDelete("cascade")->onUpdate("cascade");
    });


//
// NOTE -- organization__role_user_foreign
// --------------------------------------------------

    Schema::table('organization__role_user', function($table) {
        $table->foreign('role_id')->references('role_id')->on('organization__role')->onDelete("cascade")->onUpdate("cascade");
        $table->foreign('user_id')->references('user_id')->on('user')->onDelete("cascade")->onUpdate("cascade");
    });


//
// NOTE -- organization__user_foreign
// --------------------------------------------------

    Schema::table('organization__user', function($table) {
        $table->foreign('organization_id')->references('organization_id')->on('organization')->onDelete("cascade")->onUpdate("cascade");
        $table->foreign('user_id')->references('user_id')->on('user')->onDelete("cascade")->onUpdate("cascade");
    });



}
 
//
// NOTE - Revert the changes to the database.
// --------------------------------------------------
 
public function down()
{
    Schema::table('organization__user', function($table) {
        $table->dropForeign("organization__user_organization_id_foreign");
        $table->dropForeign("organization__user_user_id_foreign");
    });
    Schema::table('organization__role_user', function($table) {
        $table->dropForeign("organization__role_user_user_id_foreign");
        $table->dropForeign("organization__role_user_role_id_foreign");
    });
    Schema::table('organization__role_permission', function($table) {
        $table->dropForeign("organization__role_permission_permission_id_foreign");
        $table->dropForeign("organization__role_permission_role_id_foreign");
    });
    Schema::table('organization__role', function($table) {
        $table->dropForeign("organization__role_organization_id_foreign");
    });
    Schema::table('group__user', function($table) {
        $table->dropForeign("group__user_user_id_foreign");
        $table->dropForeign("group__user_group_id_foreign");
    });
    Schema::table('group', function($table) {
        $table->dropForeign("group_organization_id_foreign");
    });
    Schema::table('announcement', function($table) {
        $table->dropForeign("announcement_owner_foreign");
    });

    Schema::dropIfExists('announcement');
    Schema::dropIfExists('group');
    Schema::dropIfExists('group__user');
    Schema::dropIfExists('lookup__entity');
    Schema::dropIfExists('lookup__permissions');
    Schema::dropIfExists('organization');
    Schema::dropIfExists('organization__role');
    Schema::dropIfExists('organization__role_permission');
    Schema::dropIfExists('organization__role_user');
    Schema::dropIfExists('organization__user');
    Schema::dropIfExists('user');
    Schema::dropIfExists('user__activation_codes');
    Schema::dropIfExists('user__address');
    Schema::dropIfExists('user__credential');
    Schema::dropIfExists('user__phone');
    Schema::dropIfExists('user__social');
    Schema::dropIfExists('user__token');
    Schema::dropIfExists('user__token');
    Schema::dropIfExists('user__token');
    Schema::dropIfExists('user__token');
    Schema::dropIfExists('user__token');
    Schema::dropIfExists('user__token');
    Schema::dropIfExists('user__token');
    Schema::dropIfExists('user__token');

}
}