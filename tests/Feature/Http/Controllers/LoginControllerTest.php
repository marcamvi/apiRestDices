<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use App\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase {

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_user_with_correct_credentials() {
        $this->artisan('passport:install');
        $user = User::factory()->create(
                [
                    'password' => bcrypt($password = '123456')
                ]
        );

        $response = $this->post('/api/login', ['email' => $user->email, 'password' => $password]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_user_with_status_ok() {
        $this->artisan('passport:install');
        $user = User::factory()->create(
                [
                    'password' => bcrypt($password = '123456')
                ]
        );

        $response = $this->post('/api/login', ['email' => $user->email, 'password' => $password]);

        $response->assertStatus(200);
    }

    public function test_login_user_with_incorrect_credentials() {

        $user = User::factory()->create(
                [
                    'password' => bcrypt($password = '123456')
                ]
        );

        $response = $this->post('/api/login', ['email' => $user->email, 'password' => '12345']);

        $response->assertStatus(422);
    }

    public function test_login_user_empty_email() {

        $user = User::factory()->create();

        $response = $this->post('/api/login', ['email' => $user->email, 'password' => '']);

        $response->assertStatus(422);
    }

    public function test_login_user_empty_password() {
        $user = User::factory()->create(
                [
                    'password' => bcrypt($password = '123456')
                ]
        );

        $response = $this->post('/api/login', ['email' => '', 'password' => $password]);

        $response->assertStatus(422);
    }

    public function test_logout_user_with_status_ok() {
        $this->artisan('passport:install');
        $user = User::factory()->create();

        Passport::actingAs($user);

        $this->postJson('/api/logout')
                ->assertStatus(200);
    }

}
