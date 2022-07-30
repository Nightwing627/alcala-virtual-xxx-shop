<?php

use Illuminate\Database\Seeder;

class ExtrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extras')->insert([
        	"id"=>1,
        	"key"=>"NOSOTROS",
        	"value" => "contenido de nosotros (empresa)",
        ]);

        DB::table('extras')->insert([
        	"id"=>2,
        	"key"=>"HISTORIA",
        	"value" => "Historia de la empresa",
        ]);

        DB::table('extras')->insert([
        	"id"=>3,
        	"key"=>"EMPRESA_IMG_ID",
        	"value" => "1",
        ]);

        DB::table('extras')->insert([
        	"id"=>4,
        	"key"=>"URL_FACEBOOK",
        	"value" => "https://facebook.com",
        ]);

        DB::table('extras')->insert([
        	"id"=>5,
        	"key"=>"URL_INSTAGRAM",
        	"value" => "https://instagram.com",
		]);

        DB::table('extras')->insert([
        	"id"=>6,
        	"key"=>"EMAIL",
        	"value" => "contacto@buffetware.com",
        ]);

        DB::table('extras')->insert([
        	"id"=>7,
        	"key"=>"TELPHONE",
        	"value" => "1234567890",
		]);

		DB::table('extras')->insert([
        	"id"=>11,
        	"key"=>"URL_YOUTUBE",
        	"value" => "https://youtube.com",
        ]);
		
		DB::table('extras')->insert([
        	"id"=>10,
        	"key"=>"ADDRESS",
        	"value" => "Av. Diamante 2680.<br />Col. Bosques de la Victoria<br />Guadalajara, Jal.",
        ]);

        DB::table('extras')->insert([
        	"id"=>8,
        	"key"=>"TERMINOS_CONDICIONES",
        	"value" => "terminos y condiciones de la pagina",
        ]);

        DB::table('extras')->insert([
        	"id"=>9,
        	"key"=>"TERMINOS_IMG_ID",
        	"value" => "1",
        ]);
    }
}
