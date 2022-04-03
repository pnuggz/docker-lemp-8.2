<?php

namespace App\Http\Controller;

use App\Helper\DB;
use App\Helper\View;

class Home extends BaseController
{
    public function index()
    {
        DB::beginTransaction();

        DB::create(
            '
                INSERT INTO
                    users (
                        email,
                        password
                )
                VALUES (
                    :email,
                    :password
                )
            ',
            [
                'email' => 'test6@test.com',
                'password' => 'testing'
            ]
        );

        DB::create(
            '
                INSERT INTO
                    users (
                        email,
                        password
                )
                VALUES (
                    :email,
                    :password
                )
            ',
            [
                'email' => 'test7@test.com',
                'password' => 'testing'
            ]
        );

        DB::commitTransaction();

        $result = DB::first('select * from users WHERE id = ?;', [1]);

        return View::render('home/index/create', ['user' => $result]);
    }
}
