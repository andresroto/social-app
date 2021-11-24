<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusCommentController extends Controller
{
    
    public function store(Status $status)
    {
        request()->validate([
            'body' => 'required'
        ]); 

        $comment = Comment::create([
            'user_id' => Auth::id(), 
            'status_id' => $status->id,
            'body' => request('body')
        ]); 

        $commentResource = CommentResource::make($comment); 

        CommentCreated::dispatch($commentResource); 

        return $commentResource; 
    }
}
