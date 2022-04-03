<?php

namespace App\Http\Controller;

use App\Helper\View;

class Home extends BaseController
{
    public function index()
    {
        return View::render('home/index/create', ['foo' => 'bar']);
    }
}
