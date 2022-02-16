<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CustomersSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(WorkingOnSeeder::class);
        $this->call(TimesheetsSeeder::class);
    }
}
