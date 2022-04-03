<?php

use App\Http\Controller\Home;
use App\Http\Controller\Invoice;
use App\Helper\Router;


Router::get('/', Home::class, 'index');
Router::get('/invoice', Invoice::class, 'index');
Router::post('/invoice', Invoice::class, 'store');
