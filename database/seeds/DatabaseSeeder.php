<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * 
 * @author May Thin Khaing
 * @created 21/06/2023
 *
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * @author May Thin Khaing
     * @created 21/06/2023
     * @return void
     */
    public function run()
    {
        $this->call(EmployeeSeeder::class);
    }
}
