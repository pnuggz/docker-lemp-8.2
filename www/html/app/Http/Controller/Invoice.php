<?php

namespace App\Http\Controller;

use App\Helper\View;

class Invoice extends BaseController
{
    public function index()
    {
        return View::render('invoice/index/create');
    }
}
