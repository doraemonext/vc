<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comment', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('vc_id');
            $table->foreign('vc_id')->references('id')->on('vc');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('author_ip');
            $table->dateTime('datetime');
            $table->text('content');
            $table->integer('agree');
            $table->integer('disagree');
            $table->integer('parent');
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
        Schema::drop('comment');
	}

}
