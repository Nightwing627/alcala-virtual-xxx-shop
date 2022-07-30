<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$states=[[
				"id" => 1,
				"name" => "Aguascalientes",
				"acronym" => "AGS",
				"latitude" => "22.031581",
				"longitude" => "-102.349404",
				"zoom" => 9
			],
			[
				"id" => 2,
				"name" => "Baja California",
				"acronym" => "BCN",
				"latitude" => "30.344615",
				"longitude" => "-115.254069",
				"zoom" => 7
			],
			[
				"id" => 3,
				"name" => "Baja California Sur",
				"acronym" => "BCS",
				"latitude" => "25.859411",
				"longitude" => "-111.809855",
				"zoom" => 7
			],
			[
				"id" => 4,
				"name" => "Campeche",
				"acronym" => "CAM",
				"latitude" => "18.755709",
				"longitude" => "-90.584269",
				"zoom" => 7
			],
			[
				"id" => 5,
				"name" => "Coahuila",
				"acronym" => "COH",
				"latitude" => "27.269464",
				"longitude" => "-102.048502",
				"zoom" => 7
			],
			[
				"id" => 6,
				"name" => "Colima",
				"acronym" => "COL",
				"latitude" => "19.134986",
				"longitude" => "-103.861247",
				"zoom" => 10
			],
			[
				"id" => 7,
				"name" => "Chiapas",
				"acronym" => "CHP",
				"latitude" => "16.767927",
				"longitude" => "-92.397013",
				"zoom" => 8
			],
			[
				"id" => 8,
				"name" => "Chihuahua",
				"acronym" => "CHI",
				"latitude" => "28.888152",
				"longitude" => "-106.322184",
				"zoom" => 7
			],
			[
				"id" => 9,
				"name" => "Ciudad de Mexico",
				"acronym" => "CDMX",
				"latitude" => "19.379669",
				"longitude" => "-99.141565",
				"zoom" => 11
			],
			[
				"id" => 10,
				"name" => "Durango",
				"acronym" => "DUR",
				"latitude" => "24.825858",
				"longitude" => "-104.982858",
				"zoom" => 7
			],
			[
				"id" => 11,
				"name" => "Guanajuato",
				"acronym" => "GUA",
				"latitude" => "20.855130",
				"longitude" => "-101.220782",
				"zoom" => 9
			],
			[
				"id" => 12,
				"name" => "Guerrero",
				"acronym" => "GUE",
				"latitude" => "17.676908",
				"longitude" => "-100.083697",
				"zoom" => 8
			],
			[
				"id" => 13,
				"name" => "Hidalgo",
				"acronym" => "HID",
				"latitude" => "20.530554",
				"longitude" => "-98.884588",
				"zoom" => 9
			],
			[
				"id" => 14,
				"name" => "Jalisco",
				"acronym" => "JAL",
				"latitude" => "20.545890",
				"longitude" => "-103.770857",
				"zoom" => 8
			],
			[
				"id" => 15,
				"name" => "México",
				"acronym" => "MEX",
				"latitude" => "19.488772",
				"longitude" => "-99.655231",
				"zoom" => 9
			],
			[
				"id" => 16,
				"name" => "Michoacán",
				"acronym" => "MIC",
				"latitude" => "19.312151",
				"longitude" => "-101.890408",
				"zoom" => 8
			],
			[
				"id" => 17,
				"name" => "Morelos",
				"acronym" => "MOR",
				"latitude" => "18.746134",
				"longitude" => "-99.078835",
				"zoom" => 10
			],
			[
				"id" => 18,
				"name" => "Nayarit",
				"acronym" => "NAY",
				"latitude" => "21.824775",
				"longitude" => "-104.921345",
				"zoom" => 9
			],
			[
				"id" => 19,
				"name" => "Nuevo León",
				"acronym" => "NVL",
				"latitude" => "25.483674",
				"longitude" => "-99.773412",
				"zoom" => 7
			],
			[
				"id" => 20,
				"name" => "Oaxaca",
				"acronym" => "OAX",
				"latitude" => "17.035450",
				"longitude" => "-96.565018",
				"zoom" => 8
			],
			[
				"id" => 21,
				"name" => "Puebla",
				"acronym" => "PUE",
				"latitude" => "18.988991",
				"longitude" => "-97.848963",
				"zoom" => 8
			],
			[
				"id" => 22,
				"name" => "Querétaro",
				"acronym" => "QRO",
				"latitude" => "20.859397",
				"longitude" => "-99.853569",
				"zoom" => 9
			],
			[
				"id" => 23,
				"name" => "Quintana Roo",
				"acronym" => "QR",
				"latitude" => "19.867213",
				"longitude" => "-87.963099",
				"zoom" => 8
			],
			[
				"id" => 24,
				"name" => "San Luis Potosí",
				"acronym" => "SLP",
				"latitude" => "22.526265",
				"longitude" => "-100.413189",
				"zoom" => 8
			],
			[
				"id" => 25,
				"name" => "Sinaloa",
				"acronym" => "SIN",
				"latitude" => "25.048106",
				"longitude" => "-107.587726",
				"zoom" => 8
			],
			[
				"id" => 26,
				"name" => "Sonora",
				"acronym" => "SON",
				"latitude" => "30.064387",
				"longitude" => "-111.311709",
				"zoom" => 7
			],
			[
				"id" => 27,
				"name" => "Tabasco",
				"acronym" => "TAB",
				"latitude" => "18.145850",
				"longitude" => "-92.707880",
				"zoom" => 8
			],
			[
				"id" => 28,
				"name" => "Tamaulipas",
				"acronym" => "TAM",
				"latitude" => "24.527701",
				"longitude" => "-98.516009",
				"zoom" => 8
			],
			[
				"id" => 29,
				"name" => "Tlaxcala",
				"acronym" => "TLA",
				"latitude" => "19.447217",
				"longitude" => "-98.153383",
				"zoom" => 10
			],
			[
				"id" => 30,
				"name" => "Veracruz",
				"acronym" => "VER",
				"latitude" => "19.510988",
				"longitude" => "-96.697493",
				"zoom" => 7
			],
			[
				"id" => 31,
				"name" => "Yucatán",
				"acronym" => "YUC",
				"latitude" => "20.794774",
				"longitude" => "-89.036793",
				"zoom" => 8
			],
			[
				"id" => 32,
				"name" => "Zacatecas",
				"acronym" => "ZAC",
				"latitude" => "23.188936",
				"longitude" => "-103.045611",
				"zoom" => 8
			]];

		foreach ($states as $key => $value) {
			DB::table('states')->insert($value);
		}
        
    }
}
