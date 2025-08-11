<?php

namespace App\Http\Controllers\Admin;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

class HomeController
{
    public function index()
    {
        return view('home');
    }
}
