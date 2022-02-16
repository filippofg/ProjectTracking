<?php

use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
			'vat_number'	    => '12345678901',
			'business_name' 	=> 'Example Business',
			'referent_name'		=> 'No',
			'referent_surname'	=> 'Referent',
            'referent_email'	=> 'none@domain.xyz',
            'ssid'          	=> '1234567',
            'pec'           	=> 'none@pec.domain.xyz',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s')
        ]);
    }
}
