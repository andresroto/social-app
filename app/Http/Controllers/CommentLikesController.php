<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentLikesController extends Controller
{
    
    public function store(Comment $comment)
    {   
        $comment->like(); 
    }


    public function destroy(Comment $comment)
    {   
        $comment->unlike(); 
    }
}
