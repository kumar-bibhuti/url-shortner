<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<URL>
 */
class URLFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        return [
            'original_url' => fake()->url(),
            'short_code' => Str::random(6),
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ];
    }
}
