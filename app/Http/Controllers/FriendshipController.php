<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{

    public function store(Request $request, User $recipient)
    {    
        if(Auth::id() === $recipient->id) {
            abort(400); 
        }

        $friendship = $request->user()->sendFriendRequestTo($recipient); 

        return response()->json([
            'friendship_status' => $friendship->fresh()->status
        ]); 
    }

    public function destroy(User $user)
    {   
        $friendship = Friendship::betweenUsers(Auth::user(), $user)->first(); 

        if($friendship->status === 'denied' && (int) $friendship->sender_id === Auth::id()) {
            return response()->json([
                'friendship_status' => 'denied'
            ]); 
        }
        
        return response()->json([
            'friendship_status' => $friendship->delete() ? 'deleted' : ''
        ]); 
    }
}
