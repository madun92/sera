<?php

namespace Database\Seeders;

use App\Models\User;
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
        // $this->call('UsersTableSeeder');
        User::create([
            "username" => "madun92",
            "email" => "lamjoart@gmail.com",
            "password" => app('hash')->make('test'),
        ]);
    }
}
