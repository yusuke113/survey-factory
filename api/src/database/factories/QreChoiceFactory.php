<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\QreChoice;
use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models>
 */
class QreChoiceFactory extends Factory
{
    /**
     * ファクトリと対応するモデルの名前
     *
     * @var string
     */
    protected $model = QreChoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dateTime = fake()->dateTimeThisYear(timezone: 'Asia/Tokyo');
        $QuestionnaireIds = Questionnaire::all()->pluck('id')->toArray();
        return [
            'uuid' => (string) Str::uuid(),
            'questionnaire_id' => 1,
            'body' => fake()->realText(30),
            'display_order' => fake()->numberBetween(1, 2),
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
