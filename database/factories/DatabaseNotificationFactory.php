<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

class DatabaseNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatabaseNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid()->toString(),
            'type' => 'App\\Notifications\\ExampleNotification',
            'notifiable_type' => 'App\\User',
            'notifiable_id' => User::factory()->create(),
            'data' => [
                'link' => url('/'), 
                'message' => 'Message notification'
            ],
            'read_at' => null
        ];
    }
}
