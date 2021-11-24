<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Traits\HasLikes;


class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_belongs_to_a_user()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /** @test */
    public function a_comment_belongs_to_a_status()
    {
        $comment = Comment::factory()->create();

        $this->assertInstanceOf(Status::class, $comment->status);
    }

    /** @test */
    public function a_comment_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUsesTrait(HasLikes::class, Comment::class);
    }

    /** @test */
    public function a_comment_must_have_a_path()
    {
        $comment = Comment::factory()->create();
        
        $this->assertEquals(route('statuses.show', $comment->status_id) . '#comment-' . $comment->id, $comment->path()); 
    }

    // /** @test */
    // public function a_comment_morph_many_likes()
    // {
    //     $comment = Comment::factory()->create();

    //     Like::factory()->create([
    //         'likeable_id' => $comment->id,
    //         'likeable_type' => get_class($comment)
    //     ]);

    //     $this->assertInstanceOf(Like::class, $comment->likes->first());
    // }

    // /** @test */
    // public function a_comment_can_be_liked_and_unliked()
    // {
    //     $comment = Comment::factory()->create();

    //     $this->actingAs(User::factory()->create());

    //     $comment->like();

    //     $this->assertEquals(1, $comment->likes->count());

    //     $comment->unlike();

    //     $this->assertEquals(0, $comment->fresh()->likes->count());
    // }

    // /** @test */
    // public function a_comment_knows_if_it_has_been_liked()
    // {
    //     $comment = Comment::factory()->create();

    //     $this->assertFalse($comment->isLiked());

    //     $this->actingAs(User::factory()->create());

    //     $this->assertFalse($comment->isLiked());

    //     $comment->like();

    //     $this->assertTrue($comment->isLiked());
    // }

    // /** @test */
    // public function a_comment_knows_how_many_likes_it_has()
    // {
    //     $comment = Comment::factory()->create();

    //     $this->assertEquals(0, $comment->likesCount());

    //     Like::factory(2)->create([
    //         'likeable_id' => $comment->id,
    //         'likeable_type' => get_class($comment)
    //     ]);

    //     $this->assertEquals(2, $comment->likesCount());
    // }

}
