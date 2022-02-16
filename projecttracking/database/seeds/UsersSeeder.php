<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
			'name'		    => 'Michele',
			'surname'	    => 'Longo',
			'email'		    => 'michele.longo@student.unife.it',
			'password'	    => Hash::make('test'),
            'is_admin'      => true,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name'		    => 'Filippo',
			'surname'	    => 'Faggion',
			'email'		    => 'filippo.faggion@student.unife.it',
			'password'	    => Hash::make('test'),
			'is_admin'	    => false,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
		]);
    }
}
// $test = Hash::make('test');
// if(Hash::check('test', $test)) {
//     echo 'true';
// }
// else {
//     echo 'false';
// }
