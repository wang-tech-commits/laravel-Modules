<?php

namespace App\Api\Controllers;

class IndexController extends Controller
{

    public function index()
    {
        return $this->success('Json Api is ready');
    }
}
