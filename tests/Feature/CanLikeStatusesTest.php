<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class CanLikeStatusesTest extends TestCase
{   

    use RefreshDatabase; 

    /** @test */
    public function guests_users_can_not_like_statuses()
    {
        $status = Status::factory()->create(); 

        $response = $this->postJson(route('statuses.likes.store', $status));
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED); 
    }
    

    /** @test */
    public function an_anthenticated_user_can_like_and_unlike_statuses()
    {   
        // $this->withoutExceptionHandling(); 

        $user = User::factory()->create(); 

        $status = Status::factory()->create();

        $this->assertCount(0, $status->likes); 
        
        $response = $this->actingAs($user)->postJson(route('statuses.likes.store', $status));

        $response->assertJsonFragment([
            'likes_count' => 1
        ]); 

        $this->assertCount(1, $status->fresh()->likes); 

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id
        ]); 

        $response = $this->actingAs($user)->deleteJson(route('statuses.likes.destroy', $status)); 

        $response->assertJsonFragment([
            'likes_count' => 0
        ]); 

        $this->assertCount(0, $status->fresh()->likes); 

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id, 
        ]); 
    }

    
}
