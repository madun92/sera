<?php

namespace App\Http\Controllers;

use App\Mail\Register;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Kreait\Laravel\Firebase\Facades\FirebaseAuth;
use Kreait\Laravel\Firebase\Facades\FirebaseDatabase;

class TaskController extends Controller
{

    public function task3()
    {
        dd(FirebaseDatabase::getReference('config')->getValue());
        $database = app('firebase.database');
        $reference = $database->getReference('');
        $database->getReference('config/website')
        ->set([
            'name' => 'My Application',
            'emails' => [
                'support' => 'support@domain.tld',
                'sales' => 'sales@domain.tld',
            ],
            'website' => 'https://app.domain.tld',
            ]);

        $database->getReference('config/website/name')->set('New name');
        dd($reference);
        dd(app('firebase.auth'));
        // Return an instance of the Auth component for the default Firebase project
        $defaultAuth = FirebaseAuth::auth();
        dd($defaultAuth);
        // Return an instance of the Auth component for a specific Firebase project
        $appAuth = Firebase::project('app')->auth();
        $anotherAppAuth = Firebase::project('another-app')->auth();
    }
    public function task6Success(Request $request) 
    {
        $stack = HandlerStack::create();
        $stack->push(
            // Middleware::log(
            //     new Logger('Logger'),
            //     new MessageFormatter('{req_body} - {res_body}')
            // )
            Middleware::mapResponse(function($r){
                // dd($r);
                return $r;
            })
        );
        $client = new Client([
            // "debug" => true,
            "handler" => $stack
        ]);
        try {
            $res = $client->request('POST', 'https://reqres.in/api/register', [
                // 'auth' => ['user', 'pass']
                "form_params" => [
                    "email" => $request->email ?? "eve.holt@reqres.in",
                    "password" => $request->password ?? "pistol",
                ]
            ]);
            if($res->getStatusCode() == 200) {
                $res =json_decode( (string) $res->getBody());
                return $this->responseJson(false, $res);
            }
        } catch (ClientException $e) {
            return $this->responseJson(true, [
                "status code" => $e->getCode(),
                ] +
                json_decode((string) $e->getResponse()->getBody(),1),
                "Error Request"
            );

        }
    }

    public function task6Fail(Request $request) 
    {
        $client = new Client([
            // "debug" => true,
        ]);
        try {
            $res = $client->request('POST', 'https://reqres.in/api/login', [
                // 'auth' => ['user', 'pass']
                "form_params" => [
                    "email" => $request->email ?? "eve.holts@reqres.infail",
                    "password" => $request->password ?? "cityslicka",
                ]
            ]);
            if($res->getStatusCode() == 200) {
                $res =json_decode( (string) $res->getBody());
                return $this->responseJson(false, $res);
            }
        } catch (ClientException $e) {
            return $this->responseJson(true, [
                "status code" => $e->getCode(),
                ] +
                json_decode((string) $e->getResponse()->getBody(),1),
                "Error Request"
            );

        }
    }

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

    public function task8(Request $request) 
    {
        // dd(app('sentry'));
    }

    public function task10(Request $request) 
    {
        // dd(app('config'));
        // dd(Mail::markdown('emails.markdown.register'));
        // Mail::send('emails.register', ['greeting' => "Thank you!"], function($message) {
        //     $message->to("madun92@gmail.com", 'Registration')->subject
        //     ('Registration Successfully!');
        //     $message->from(env('MAIL_USERNAME'),env('APP_NAME'));
        // });
        $data = ['greeting' => "Thank you!"];
        return Mail::to("lamjoart@gmail.com")->send(new Register($data));
    }

    //
}
