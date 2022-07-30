<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
        	"id"=>1,
        	"path"=>"photos/logo.png",
        	"disk"=>"public",
        	"key"=>"logo",
        ]);

        DB::table('images')->insert([
            "id"=>2,
            "path"=>"photos/default.png",
            "disk"=>"public",
            "key"=>"default",
        ]);
    }
}
