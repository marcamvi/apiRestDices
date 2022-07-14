<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);

            if (($dice1 + $dice2) == 7) {
                $throw = 1; //Victoria
            } else {
                $throw = 0; //Derrota
            }
        return [
            'Tirada_Uno' => $dice1,
            'Tirada_Dos' => $dice2,
            'Derrota_Victoria' =>$throw,
            'user_id'=> User::all()->random()->id
        ];
    }
}
