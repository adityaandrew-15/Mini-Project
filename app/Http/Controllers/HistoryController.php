<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::orderBy('created_at', 'desc')->get();
        return view('histories', compact('histories'));
    }
}
