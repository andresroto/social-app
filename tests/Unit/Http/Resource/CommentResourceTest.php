<?php

namespace Tests\Unit\Http\Resource;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Status;
use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CommentResourceTest extends TestCase
{
    
    use RefreshDatabase; 

    /** @test */
    public function a_comment_resource_must_have_the_necesary_fields()
    {
        $comment = Status::factory()->create();

        $commentResource = CommentResource::make($comment)->resolve(); 

        $this->assertEquals(
            $comment->id, 
            $commentResource['id']
        );

        $this->assertEquals(
            $comment->body, 
            $commentResource['body']
        );

        $this->assertEquals(
            0, 
            $commentResource['likes_count']
        );

        $this->assertEquals(
            false, 
            $commentResource['is_liked']
        );


        $this->assertInstanceOf(
            UserResource::class, 
            $commentResource['user']
        );

        $this->assertEquals(
            $comment->created_at->diffForHumans(),
            $commentResource['ago']
        );

        $this->assertInstanceOf(
            User::class, 
            $commentResource['user']->resource
        );

    }
    

}
