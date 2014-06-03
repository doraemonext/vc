<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowcase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('showcase', function($table)
        {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('company', 255);
            $table->string('contact_person', 255);
            $table->string('contact_email', 255);
            $table->string('contact_phone', 255);
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category');
            $table->string('operation_time', 255);
            $table->text('summary');
            $table->longText('content');
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
		Schema::drop('showcase');
	}

}
