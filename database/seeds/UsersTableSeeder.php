<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')
            ->insert(
                [
                    [
                        "id" => 1,
                        "name" => "Test User",
                        "email" => 'test@test.de',
//                "password" => password_hash("test", 1)
                        "password" => "test"
                    ],
                    [
                        "id" => 2,
                        "name" => "Marvin Wank",
                        "email" => 'marvin.wank@test.de',
//                "password" => password_hash("test", 1)
                        "password" => "test"
                    ]
                ]
            );
    }
}
