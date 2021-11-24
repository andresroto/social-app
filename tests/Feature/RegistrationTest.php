<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** @test */
    public function new_users_can_register()
    {   
        $this->get(route('register'))->assertSuccessful();

        $response = $this->post(route('register'), $this->userValidationData());

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->assertDatabaseHas('users', [
            'name' => 'admin_2',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com'
        ]);

        $this->assertTrue(Hash::check(
            'password',
            User::first()->password
        ), 'The password must be hashed');
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['name' => null])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['name' => null])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['name' => Str::random(61)])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_unique()
    {
        User::factory()->create(['name' => 'admin']);

        $this->post(
            route('register'),
            $this->userValidationData(['name' => 'admin'])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_may_only_contain_letters_and_numbers()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['name' => 'admin test'])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function the_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['name' => '12'])
        )->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_first_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function a_first_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['first_name' => Str::random(61)])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['first_name' => '12'])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function the_first_name_may_only_contain_letters_and_numbers()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['first_name' => 'admin test'])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function a_last_name_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['first_name' => null])
        )->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function a_last_name_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['last_name' => null])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_not_be_greater_than_60_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['last_name' => Str::random(61)])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_must_be_at_least_3_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['last_name' => '12'])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function the_last_name_may_only_contain_letters_and_numbers()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['last_name' => 'admin test'])
        )->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function a_email_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['email' => null])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_email_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['email' => null])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_a_valid_email_address()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['email' => 'test'])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_may_not_be_greater_than_100_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['email' => Str::random(101)])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        User::factory()->create(['email' => 'admin@admin.com']);

        $this->post(
            route('register'),
            $this->userValidationData(['email' => 'admin@admin.com'])
        )->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_password_is_required()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['password' => null])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function a_pasword_must_be_a_string()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['password' => 12323])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->post(
            route('register'),
            $this->userValidationData([
                'password' => 'password',
                'password_confirmation' => ''
            ])
        )->assertSessionHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_at_least_6_characters()
    {
        $this->post(
            route('register'),
            $this->userValidationData(['password' => 10122])
        )->assertSessionHasErrors('password');
    }

    /**
     * @param array $overrides
     * @return array
     */
    public function userValidationData($overrides = []): array
    {
        return array_merge([
            'name' => 'admin_2',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ], $overrides);
    }
}
