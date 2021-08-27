<?php

use App\Models\User;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{

    // protected $email;
    // protected $password;

    // public function setUp() :void
    // {
    //     parent::setUp();
    //     $this->email = "const@mail.com";
    // }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $faker = Factory::create();
        $username = $faker->userName();
        $email = $faker->safeEmail();
        $password = app('hash')->make('secret');
        // $response = 
        $this->post('/api/register',[
            "username" => $username,
            "email" => $email,
            "password" => $password,
        ]);
        // $response = json_decode($this->response->getContent());
        $this->email = $email;
        $this->password = $password;
        $this->assertResponseStatus(200);
        $this->seeJsonContains([
            // "error" => false,
            "email" => $this->email
            // "data" => [
            // ]
        ]);
        User::where('email', $email)->delete();
    }
    /**
     * 
     * @depends  testRegister
     */
    public function testLogin()
    {
        $faker = Factory::create();
        $username = $faker->userName();
        $email = $faker->safeEmail();
        $password = app('hash')->make('secret');
        $user = User::create([
            "username" => $username,
            "email" => $email,
            "password" => $password,
        ]);
        $this->post('/api/login',[
            "email" => $email,
            "password" => "secret",
        ]);
        $this->assertResponseStatus(200);
        $this->seeJson([
            "error" => false,
        ]);
        User::where('email', $email)->delete();
    }

    public function testLogout()
    {
        $user   = User::first();
        $token = JWTAuth::fromUser($user); 
        $this->json('GET', '/api/logout',[], [
            "authorization" => "bearer $token"
        ]);

        $this->seeJson([
            "error" => false,
        ]);

    }
}
