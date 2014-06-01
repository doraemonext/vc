<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentRating extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comment_rating', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('vc_id');
            $table->foreign('vc_id')->references('id')->on('vc');
            $table->unsignedInteger('comment_id');
            $table->foreign('comment_id')->references('id')->on('comment');
            $table->unsignedInteger('comment_rating_category_id');
            $table->foreign('comment_rating_category_id')->references('id')->on('comment_rating_category');
            $table->float('score');
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
		Schema::drop('comment_rating');
	}

}
