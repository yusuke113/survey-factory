<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\QreChoice;
use App\Models\Questionnaire;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('qre_choices')->truncate();
        DB::table('questionnaires')->truncate();
        DB::table('questionnaire_tag')->truncate();

        Questionnaire::factory()->count(12)
            // アンケート選択肢
            ->has(QreChoice::factory(2)->state(new Sequence(
                ['display_order' => 1],
                ['display_order' => 2],
            )))
            ->create()
            ->each(function ($questionnaire) {
                $tags = Tag::all()->pluck('id')->toArray();

                // questionnaire_tagテーブルへカテゴリデータ追加
                $randomNumArray = range(1, count($tags));
                shuffle($randomNumArray);
                $questionnaire->tags()->attach($randomNumArray[0]);
                $questionnaire->tags()->attach($randomNumArray[1]);
            });
    }
}
