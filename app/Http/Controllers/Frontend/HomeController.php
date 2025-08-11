<?php

namespace App\Http\Controllers\Frontend;

use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        return view('frontend.home');
    }
}
