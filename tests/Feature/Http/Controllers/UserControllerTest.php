<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase {

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_admin_can_see_all_users() {

$this->artisan('passport:install');

        $admin = User::factory()->create(['role'=>"1"]);
$response = $this->actingAs($admin, 'api')->get('/api/all');
            $response->assertOk();
        
         
    }

    //  public function test_correct_token_can_see_all_users()
    //   {
    //   }
    //      public function test_incorrect_token_cant_see_all_users()
    //   {
    //  }
    public function test_user_can_see_update_nickname() {
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->put(route('update', $user->id), ['name' => 'Marta']);
        $response->assertOk();
        $this->assertDatabaseHas('users', [ 'name' => 'Marta']);
    }

    //      public function test_correct_token_can_update_nickname()
    //  {
    //  }
    //          public function test_correct_token_cant_update_nickname()
    //  {
    //  }
    //     public function test_update_with_empty_nickname()
    //   {
    //   }
}
