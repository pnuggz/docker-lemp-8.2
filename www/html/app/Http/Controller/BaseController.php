<?php

namespace App\Http\Controller;

abstract class BaseController
{
    public function __construct(private array $query_strings = [])
    {
    }
}
