<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use App\Models\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase {

 //use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register_user_on_database() {
        $user = User::factory()->create([
            'name' => 'Test8',
            'email' => 'test8@gmail.com',
            'password' => '123456',
            'role' => 0]);
        $response = $this->post('/api/players', $user->toArray());
        $this->assertDatabaseHas('users', $user->toArray());
        }
    public function test_register_user_status_ok() {
        $user = [
            'name' => 'test7',
            'email' => 'test7@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 0];
        
        $response = $this->post('/api/players', $user);
        
        $response->assertStatus(201);
        }
        public function test_register_user_with_empty_name () {
        $user = User::factory()->create([
            'name' => '',
            'email' => 'test6@gmail.com',
            'password' => '123456',
            'role' => 0]);
        $response = $this->post('/api/players', $user->toArray());
        $this->assertDatabaseHas('users', $user->toArray());
        }
        public function test_register_user_with_empty_values () {
         $user = [
            'name' => 'test5',
            'email' => '',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 0];
        $response = $this->postJson('/api/players', $user);
        $response->assertStatus(422);
        }
}
