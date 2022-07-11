<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Game;
use Tests\TestCase;

class GameControllerTest extends TestCase {

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_store() {

        $this->artisan('passport:install');

        $user = User::factory()->create();

        $game = Game::factory()->create();
        $response = $this->actingAs($user, 'api')->post('api/players/' . $user->id . '/games');

        $this->assertDatabaseHas('games', $game->toArray());
        $response->assertStatus(201);
    }

    public function test_user_can_delete() {

        $this->artisan('passport:install');

        $user = User::factory()->create();
        $game = Game::factory()->create();
        $response = $this->actingAs($user, 'api')->delete('api/players/' . $user->id . '/games');

        $response->assertStatus(200);
    }

    public function test_user_can_show() {

        $this->artisan('passport:install');

        $user = User::factory()->create();
        $game = Game::factory()->create();
        $response = $this->actingAs($user, 'api')->delete('api/players/' . $user->id . '/games');

        $response->assertStatus(200);
    }

    public function test_auth_admin_user_can_see_successRate() {
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get('api/players');
        $response->assertStatus(200);
    }

    public function test_unauth_user_cant_see_succesRate() {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $this
                ->json('get', '/api/players')
                ->assertStatus(401);
    }
     public function test_no_admin_user_cant_see_succesRate() {
        $this->artisan('passport:install');

        $user = User::factory()->create(['role' => "0"]);

        $response = $this->actingAs($user, 'api')->get('api/players');
        $response->assertStatus(403);
    }

    public function test_auth_admin_user_can_see_ranking() {
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get('api/players/ranking');
        $response->assertStatus(200);
    }

    public function test_no_admin_user_cant_see_ranking() {
        $this->artisan('passport:install');

        $user = User::factory()->create(['role' => "0"]);

        $response = $this->actingAs($user, 'api')->get('api/players/ranking');
        $response->assertStatus(403);
    }

    public function test_unauth_user_cant_see_ranking() {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $this
                ->json('get', '/api/players/ranking')
                ->assertStatus(401);
    }

    public function test_auth_admin_user_can_see_rankingLoser() {
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get('api/players/ranking/loser');
        $response->assertStatus(200);
    }

    public function test_no_admin_user_cant_see_rankingLoser() {
        $this->artisan('passport:install');

        $user = User::factory()->create(['role' => "0"]);

        $response = $this->actingAs($user, 'api')->get('api/players/ranking/loser');
        $response->assertStatus(403);
    }

    public function test_unauth_user_cant_see_rankingLoser() {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $this
                ->json('get', '/api/players/ranking/loser')
                ->assertStatus(401);
    }

    public function test_auth_admin_user_can_see_rankingWinner() {
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get('api/players/ranking/winner');
        $response->assertStatus(200);
    }

    public function test_no_admin_user_cant_see_rankingWinner() {
        $this->artisan('passport:install');

        $user = User::factory()->create(['role' => "0"]);

        $response = $this->actingAs($user, 'api')->get('api/players/ranking/winner');
        $response->assertStatus(403);
    }

    public function test_unauth_user_cant_see_rankingWinner() {
        $this->artisan('passport:install');

        $user = User::factory()->create();
        $this
                ->json('get', '/api/players/ranking/winner')
                ->assertStatus(401);
    }

}
