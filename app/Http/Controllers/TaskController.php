<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    public function task7(Request $request) 
    {
        $client = new Client();
        $res = $client->request('GET', 'https://gist.githubusercontent.com/Loetfi/fe38a350deeebeb6a92526f6762bd719/raw/9899cf13cc58adac0a65de91642f87c63979960d/filter-data.json', [
            // 'auth' => ['user', 'pass']
        ]);
        if($res->getStatusCode() == 200) {
            $res = (string) $res->getBody();
            $data = json_decode($res)->data;
            $bills = collect($data->response->billdetails);
            $bills = $bills->map(function($v, $k){
                $denom = (int) explode(':', $v->body[0])[1];
                // return $denom >= 100000 ;
                if ($denom >= 100000) {
                    return $denom;
                }
            })->reject(function($val){
                return $val == null;
            })->values()->all();
            print_r($bills);
            // return response()->json($bills);
        }
    }


    //
}
