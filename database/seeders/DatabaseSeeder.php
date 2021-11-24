<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('test123')
        ]); 

        User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('test123')
        ]); 

        User::factory()->create([
            'email' => 'user2@test.com',
            'password' => bcrypt('test123')
        ]); 

        User::factory(10)->create();
        Status::factory(10)->create();

    }
}
