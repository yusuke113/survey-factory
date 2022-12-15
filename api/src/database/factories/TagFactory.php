<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TagFactory extends Factory
{
    /**
     * ファクトリと対応するモデルの名前
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dateTime = fake()->dateTimeThisYear(timezone: 'Asia/Tokyo');
        return [
            'uuid' => (string) Str::uuid(),
            'name' => fake()->word(),
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
