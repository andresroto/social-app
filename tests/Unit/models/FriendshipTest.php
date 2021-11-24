<?php

namespace Tests\Unit\Models;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class FriendshipTest extends TestCase
{   
    use RefreshDatabase;

    /** @test */
    public function a_friendship_request_belongs_to_a_sender()
    {   
        $this->withoutExceptionHandling(); 

        $sender = User::factory()->create(); 

        $friendship = Friendship::factory()->create(['recipient_id' => $sender->id]); 

        $this->assertInstanceOf(User::class, $friendship->sender); 
    }

    /** @test */
    public function a_friendship_request_belongs_to_a_recipient()
    {   
        // $this->withoutExceptionHandling(); 

        $recipient = User::factory()->create(); 

        $friendship = Friendship::factory()->create(['sender_id' => $recipient->id]); 

        $this->assertInstanceOf(User::class, $friendship->recipient); 
    }

    /** @test */
    public function can_find_friendship_by_sender_and_recipient()
    {
        $sender = User::factory()->create(); 
        $recipient = User::factory()->create(); 

        Friendship::factory(2)->create(['recipient_id' => $recipient->id]); 

        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id
        ]); 

        $foundFriendship = Friendship::betweenUsers($sender, $recipient)->first(); 

        $this->assertEquals($sender->id, $foundFriendship->sender_id);
        $this->assertEquals($recipient->id, $foundFriendship->recipient_id);

        $foundFriendship2 = Friendship::betweenUsers($recipient, $sender)->first(); 

        $this->assertEquals($sender->id, $foundFriendship2->sender_id);
        $this->assertEquals($recipient->id, $foundFriendship2->recipient_id);
    }
}
