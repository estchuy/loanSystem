<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbCreation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username');
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->integer('user_type_id');
			$table->string('phone');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('user_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('menu', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('route');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('personal_id');
			$table->text('address');
			$table->string('phone');
			$table->softDeletes();
			$table->timestamps();
		});

		Schema::create('loans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('client_id');
			$table->float("amnt", 11, 2);
			$table->integer('period_id');
			$table->float("monthly_payment", 11, 2);
			$table->integer('interest');
			$table->softDeletes();
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
		Schema::dropIfExists("users");
		Schema::dropIfExists("user_types");
		Schema::dropIfExists("menu");
		Schema::dropIfExists("clients");
		Schema::dropIfExists("loans");
	}

}
