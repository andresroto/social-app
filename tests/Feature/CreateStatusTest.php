<?php

namespace Tests\Feature;

use App\Events\StatusCreated;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{

    use RefreshDatabase; 

    /** @test */
    public function guests_users_cannot_create_statuses()
    {   
        // $this->withoutExceptionHandling(); 
        $response = $this->postJson(route('statuses.store'), ['body' => 'My first status']); 

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);  
    }
    

    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {
        // $this->withoutExceptionHandling(); 
        Event::fake([StatusCreated::class]); 

        $user = User::factory()->create();
        $this->actingAs($user); 

        $response = $this->postJson(route('statuses.store'), ['body' => 'My first status']);

        $response->assertJson([
            'data' => ['body' => 'My first status']
        ]); 

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'My first status'
        ]); 
    }

    /** @test */
    public function an_event_is_fired_when_a_status_is_created()
    {
        Event::fake([StatusCreated::class]); 
        Broadcast::shouldReceive('socket')->andReturn('socket-id'); 

        $user = User::factory()->create();

        $this->actingAs($user)->postJson(route('statuses.store'), ['body' => 'My first status']);

        Event::assertDispatched(StatusCreated::class, function($statusCreatedEvent){

            $this->assertInstanceOf(StatusResource::class, $statusCreatedEvent->status);
            $this->assertTrue(Status::first()->is($statusCreatedEvent->status->resource)); 
            $this->assertEventChannelType('public', $statusCreatedEvent); 
            $this->assertEventChannelName('statuses', $statusCreatedEvent); 
            $this->assertDontBroadcastToCurrentUser($statusCreatedEvent); 
            $this->assertEquals(Status::first()->id, $statusCreatedEvent->status->id);
            
            return true; 
        });
    }


    /** @test */
    public function a_status_requires_a_body()
    {
        $user = User::factory()->create();
        $this->actingAs($user); 

        $response = $this->postJson(route('statuses.store'), ['body' => '']); 

        $response->assertStatus(422); 

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]); 
    }

     /** @test */
     public function a_status_requires_a_minimum_length()
     {
         $user = User::factory()->create();
         $this->actingAs($user); 
 
         $response = $this->postJson(route('statuses.store'), ['body' => 'aasd']); 
 
         $response->assertStatus(422); 
 
         $response->assertJsonStructure([
             'message', 'errors' => ['body']
         ]); 
     }
    
}
