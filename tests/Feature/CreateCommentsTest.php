<?php

namespace Tests\Feature;

use App\Events\CommentCreated;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Broadcast;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase; 

    /** @test */
    public function guest_users_cannot_create_comments()
    {
        $status = Status::factory()->create();
        $comment = 'My first comment'; 

        $response = $this->postJson(route('statuses.comments.store', $status), ['body' => $comment]); 

        $response->assertStatus(Response::HTTP_UNAUTHORIZED); 
    }
    

    /** @test */
    public function authenticated_users_can_comment_statuses()
    {   
        // $this->withoutExceptionHandling(); 

        $status = Status::factory()->create();
        $user = User::factory()->create(); 
        $comment = ['body' => 'My first comment']; 

        $response = $this->actingAs($user)->postJson(route('statuses.comments.store', $status), $comment);
        
        $response->assertJson([
            'data' => ['body' => $comment['body']]
        ]); 

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment
        ]); 
    }
    

    /** @test */
    public function a_comment_requires_a_body()
    {
        $status = Status::factory()->create(); 

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('statuses.comments.store', $status), ['body' => '']); 

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /** @test */
    public function an_event_is_fired_when_a_comment_is_created()
    {
        Event::fake([CommentCreated::class]); 
        Broadcast::shouldReceive('socket')->andReturn('socket-id'); 
        
        $status = Status::factory()->create();
        $user = User::factory()->create(); 
        $comment = ['body' => 'My first comment']; 

        $this->actingAs($user)->postJson(route('statuses.comments.store', $status), $comment);

        Event::assertDispatched(CommentCreated::class, function($commentStatusEvent){

            $this->assertInstanceOf(CommentResource::class, $commentStatusEvent->comment);
            $this->assertTrue(Comment::first()->is($commentStatusEvent->comment->resource)); 
            $this->assertEventChannelType('public', $commentStatusEvent); 
            $this->assertEventChannelName("statuses.{$commentStatusEvent->comment->status_id}.comments", $commentStatusEvent); 
            $this->assertDontBroadcastToCurrentUser($commentStatusEvent); 
            return true; 
        });
    }

}
