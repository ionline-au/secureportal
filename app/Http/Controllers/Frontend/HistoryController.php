<?php

namespace App\Http\Controllers\Frontend;

use App\Models\History;
use Illuminate\Support\Facades\Auth;

class HistoryController
{
    public function index()
    {
        $history = History::orderBy('id','desc')->where('user_id', Auth::id())->get();
        return view('frontend.history.index', compact('history'));
    }
}