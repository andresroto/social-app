<?php

namespace App\Models\Traits;

use App\Events\ModelLiked;
use App\Events\ModelUnliked;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait HasLikes 
{

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        $this->likes()->firstOrCreate([
            'user_id' => Auth::id()
        ]);

        ModelLiked::dispatch($this, Auth::user()); 
    }

    public function unlike()
    {
        $this->likes()->where([
            'user_id' => Auth::id()
        ])->delete();

        ModelUnliked::dispatch($this); 
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::id())->exists(); 
    }

    public function likesCount()
    {
        return $this->likes()->count(); 
    }

    public function eventChannelName()
    {
        return strtolower(Str::plural(class_basename($this))) . "." . $this->getKey() . ".likes"; 
    }

    abstract public function path();
}
