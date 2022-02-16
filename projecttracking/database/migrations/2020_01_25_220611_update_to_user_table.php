<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateToUserTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			/* $table->dropColumn([
				'id',
				'email_verified_at'
			]);

			$table->dropTimestamps();
			$table->dropRememberToken();

			$table->primary('email')->first();
			$table->string('surname')->after('name');

			// $table->string('role', 8)->default('standard');
			$table->enum('role', ['standard', 'admin'])->default('standard'); */
			$table->string('surname')
				->after('name')
				->nullable();
			$table->boolean('is_admin')
				->after('password')
				->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			/* $table->dropColumn([
                'email',
                'surname',
                'role'
            ]);

            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
			$table->timestamps(); */
			$table->dropColumn(['surname', 'is_admin']);
		});
	}
}
