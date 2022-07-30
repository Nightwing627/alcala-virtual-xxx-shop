<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\State;
use App\Town;


class SepomexController extends Controller
{
    private $token = "e2dfe2bb-7b7b-4710-8818-7bd4fbb8f6a6";

    public function getZipCode($postalCode)
    {
        $client = new Client();
        $url = "https://api-sepomex.hckdrk.mx/query/search_cp/$postalCode?token=".$this->token;
        $response = $client->get($url);
        $output = json_decode($response->getBody()->getContents(), true);

        if($output['error'] == false){
            return response()->json($output['response']['cp']);
        }

        return [];
    }

    public function infoZipCode($postalCode)
    {
        $colonias = [];
        $state = [];
        $town = [];

        $client = new Client();
        $url = "https://api-sepomex.hckdrk.mx/query/info_cp/$postalCode?type=simplified&token=".$this->token;
        $response = $client->get($url);
        $output = json_decode($response->getBody()->getContents(), true);

        if($output['error'] == false){
            $colonias = $output['response']['asentamiento'];
            $state = State::where('name', $output['response']['estado'])->select('id','name')->get();
            $town = Town::where('name', $output['response']['municipio'])->select('id','name')->get();
        }
        
        return response()->json(['colonias' => $colonias, 'states'=> $state->toArray(), 'towns'=> $town->toArray()]);
    }
}
