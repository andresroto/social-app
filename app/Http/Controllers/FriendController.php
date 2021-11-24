<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    
    public function index()
    {      
        return view('friends.index', [
            'friends' => Auth::user()->friends()
        ]); 
    }
}
