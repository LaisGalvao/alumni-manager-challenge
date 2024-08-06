<?php

use Illuminate\Database\Seeder;
use Database\seeds\UserSeeder;
use Database\seeds\RoleSeeder;
use Database\seeds\GroupSeeder;
use Database\seeds\ExtFielSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            GroupSeeder::class,
            UserSeeder::class,
            ExtFielSeeder::class
        ]);
        shell_exec('php ../artisan passport:install');
    }
}
