<?php

namespace Tests;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function assertClassUsesTrait($trait, $class)
    {
        $this->assertArrayHasKey(
            $trait, 
            class_uses($class), 
            "{$class} class musb use {$trait} trait"
        ); 
    }

    protected function assertDontBroadcastToCurrentUser($event, $socketId = 'socket-id') 
    {
        $this->assertInstanceOf(ShouldBroadcast::class, $event);

        $this->assertEquals(
            $socketId, 
            $event->socket, 
            'The event' . get_class($event) . 'must call the method "dontBroadcastToCurrentUser" in the constructor');
    }

    protected function assertEventChannelType($channelType, $event) 
    {
        $types = [
            'public' => \Illuminate\Broadcasting\Channel::class,
            'private' => \Illuminate\Broadcasting\PrivateChannel::class,
            'presence' => \Illuminate\Broadcasting\PresenceChannel::class
        ];

        $this->assertEquals($types[$channelType], get_class($event->broadcastOn()));
    }

    protected function assertEventChannelName($channelName, $event) 
    {
        $this->assertEquals($channelName, $event->broadcastOn()->name);
    }
}
