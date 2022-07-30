<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatesTableSeeder::class);
        $this->call(TownsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(PermsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(ExtrasTableSeeder::class);
    }
}
