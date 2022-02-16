<?php

use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
			'name'                  => 'PhpStorm',
			'description'           => 'None',
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
            'customer_vat_number'   => '12345678901',
            'cost_per_hour'         => 5.60
        ]);
        DB::table('projects')->insert([
			'name'                  => 'IntelliJ IDEA',
			'description'           => 'None',
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
            'customer_vat_number'   => '12345678901',
            'cost_per_hour'         => 4.20
        ]);
    }
}
