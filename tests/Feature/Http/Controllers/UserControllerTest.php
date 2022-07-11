<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class UserControllerTest extends TestCase {

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_user_can_see_all_users() {

        $this->artisan('passport:install');

        $admin = User::factory()->create(['role' => "1"]);

            $response = $this->actingAs($admin, 'api')->get('/api/all');    
            $response->assertOk();
    $this->assertAuthenticated();
        
    }

  public function test_auth_user_can_see_all_users() {
      $this->artisan('passport:install');
        
     $admin = User::factory()->create();
    
     $response = $this->actingAs($admin, 'api')->get('/api/all');
     $this->assertAuthenticated();
  }

  public function test_unauth_user_cant_see_all_users()
   {
               $this->artisan('passport:install');

         $this
        ->json('GET', '/api/all')
        ->assertStatus(401);
    }
   public function test_auth_user_can_update_name() {
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->put(route('update', $user->id), ['name' => 'Marta']);
        $this->assertAuthenticated();
        $response->assertOk();
        $this->assertDatabaseHas('users', ['name' => 'Marta']);
    }

    public function test_unauth_user_cant_update_name()
    {
                $this->artisan('passport:install');
$user = User::factory()->create();
         $this
        ->putjson(route ('update', $user->id), ['name' => 'Marta'])
        ->assertStatus(401);
    }
     
    //          public function test_correct_auth_can_update_nickname()
    //  {
    //  }
    //     public function test_update_with_empty_nickname()
    //   {
    //   }
}
