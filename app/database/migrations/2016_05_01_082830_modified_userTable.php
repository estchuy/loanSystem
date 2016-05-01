<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifiedUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
		    $table->renameColumn('hashpasw', 'password');
		    $table->string('remember_token');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint  $table)
		{
			$table->renameColumn('password', 'hashpasw');
		    $table->dropColumn('remember_token');
		});
	}

}
