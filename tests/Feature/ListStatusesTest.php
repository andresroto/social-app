<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListStatusesTest extends TestCase
{

    use RefreshDatabase; 

    /** @test */
    public function can_get_all_statuses()
    {
        $statuses = Status::factory(4)->create();

        $response = $this->getJson(route('statuses.index')); 

        $response->assertSuccessful(); 

        $response->assertJson([
            'meta' => ['total' => 4]
        ]); 

        $response->assertJsonStructure([
            'data', 'links' => ['next', 'prev']
        ]); 

        $this->assertEquals(
            $statuses->last()->body, 
            $response->json('data.0.body')
        ); 

    }
    
    /** @test */
    public function can_get_statuses_for_a_specific_user()
    {   
        // $this->withoutExceptionHandling(); 
        
        $user = User::factory()->create(); 

        $status1 = Status::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDay() ]); 
        $status2 = Status::factory()->create(['user_id' => $user->id]); 

        Status::factory(2)->create();

        $response = $this->actingAs($user)->getJson(route('users.statuses.index', $user)); 

        $response->assertJson([
            'meta' => ['total' => 2]
        ]); 

        $response->assertJsonStructure([
            'data', 'links' => ['prev', 'next']
        ]); 

        $this->assertEquals(
            $status2->body, 
            $response->json('data.0.body')
        );

    }

    /** @test */
    public function can_see_individual_status()
    {   
        $status = Status::factory()->create(); 

        $this->get($status->path())->assertSee($status->body); 
    }
    
    
    
}
