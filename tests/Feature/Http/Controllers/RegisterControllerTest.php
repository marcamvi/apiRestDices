<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use App\Models\User;
use Tests\TestCase;


class RegisterControllerTest extends TestCase {

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_user_on_database() {
        $user = User::factory()->create();
        $response = $this->post('/api/players', $user->toArray());
        $this->assertDatabaseHas('users', $user->toArray());
    }

    public function test_register_user_status_ok() {
      $this->artisan('passport:install');
        $user = [
            'name' => 'test99',
            'email' => 'test99@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 0];

        $response = $this->post('/api/players', $user);

        $response->assertStatus(201);
    }

    public function test_register_user_with_empty_name() {
        $this->artisan('passport:install');
        $user = [
            'name' => '',
            'email' => 'test99@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 0];

        $response = $this->post('/api/players', $user);

        $response->assertStatus(201);
    }

    public function test_register_user_with_empty_email() {
        $this->artisan('passport:install');
        $user = [
            'name' => 'test97',
            'email' => '',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 0];
        $response = $this->postJson('/api/players', $user);
        $response->assertStatus(422);
    }
        public function test_register_user_with_empty_password() {
        $this->artisan('passport:install');
        $user = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '',
            'password_confirmation' => '',
            'role' => 0];
        $response = $this->postJson('/api/players', $user);
        $response->assertStatus(422);
    }
    
            public function test_register_user_with_wrong_password_confirmation() {
        $this->artisan('passport:install');
        $user = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'password_confirmation' => '12345',
            'role' => 0];
        $response = $this->postJson('/api/players', $user);
        $response->assertStatus(422);
    }
                public function test_register_user_with_existing_name_or_email() {
        $this->artisan('passport:install');
        $user = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'password_confirmation' => '12345',
            'role' => 0];
                $user2 = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'password_confirmation' => '12345',
            'role' => 0];
        $response = $this->postJson('/api/players', $user2);
        $response->assertStatus(422);
    }

}
