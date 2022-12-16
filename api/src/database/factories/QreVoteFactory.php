<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\QreChoice;
use App\Models\QreVote;
use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models>
 */
class QreVoteFactory extends Factory
{
    /**
     * ファクトリと対応するモデルの名前
     *
     * @var string
     */
    protected $model = QreVote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dateTime = fake()->dateTimeThisYear(timezone: 'Asia/Tokyo');
        $questionnaireIds = Questionnaire::all()->pluck('id')->toArray();
        $questionnaire = Questionnaire::find(fake()->randomElement($questionnaireIds));
        $qreChoices = $questionnaire->qreChoices()->pluck('id')->toArray();
        return [
            'uuid' => (string) Str::uuid(),
            'questionnaire_id' => $questionnaire->id,
            'qre_choice_id' => fake()->randomElement($qreChoices),
            'user_token' => Str::random(24),
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ];
    }
}
