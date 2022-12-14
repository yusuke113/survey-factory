<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models>
 */
class QuestionnaireFactory extends Factory
{
    /**
     * ファクトリと対応するモデルの名前
     *
     * @var string
     */
    protected $model = Questionnaire::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dateTime = fake()->dateTimeThisYear(timezone: 'Asia/Tokyo');
        $userIds = User::all()->pluck('id')->toArray();
        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => fake()->randomElement($userIds),
            'title' => fake()->realText(30, 1),
            'description' => fake()->realText(50, 1),
            'thumbnail_url' => fake()->imageUrl(1280, 1280),
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
