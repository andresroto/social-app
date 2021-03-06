<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, 
            'body' => $this->body, 
            'user' => UserResource::make($this->user),
            'is_liked' => $this->isLiked(), 
            'likes_count' => $this->likesCount(),
            'comments' => CommentResource::collection($this->comments), 
            'ago' => $this->created_at->diffForHumans()
        ]; 
    }
}
