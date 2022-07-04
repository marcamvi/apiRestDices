<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_user()
    {
                $user = User::factory()->create([
            'name'=>'Test', 
            'email'=>'test@gmail.com', 
            'password'=>'123456',
            'role'=>0]);
        $response = $this->post('register', $user->toArray());
        $this->assertDatabaseHas('users', $user->toArray());
    }
}
