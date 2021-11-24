<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanSeeProfileTest extends TestCase
{   
    use RefreshDatabase; 

    /** @test */
    public function can_see_profiles()
    {
        // $this->withoutExceptionHandling(); 
        User::factory()->create([
            'name' => 'admin'
        ]); 

        $this->get('@admin')->assertSee('admin');   
    }
    
}
