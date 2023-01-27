<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\QreChoice;
use App\Models\Questionnaire;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

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

        // アンケートダミーデータ
        $questionnaireList = [
            [['title' => 'Windows or MacOS?'], ['choice' => ['Windows', 'MacOS']]],
            [['title' => 'iPhone or Android?'], ['choice' => ['iPhone', 'Android']]],
            [['title' => 'コーラ or ペプシ?'], ['choice' => ['コーラ', 'ペプシ']]],
            [['title' => 'ハンバーガー or ピザ?'], ['choice' => ['ハンバーガー', 'ピザ']]],
            [['title' => '夜明け or 夕方?'], ['choice' => ['夜明け', '夕方']]],
            [['title' => '夏 or 冬?'], ['choice' => ['夏', '冬']]],
            [['title' => '犬 or 猫?'], ['choice' => ['犬', '猫']]],
            [['title' => '山 or 海?'], ['choice' => ['山', '海']]],
            [['title' => 'ハリー・ポッター or ロード・オブ・ザ・リング?'], ['choice' => ['ハリー・ポッター', 'ロード・オブ・ザ・リング']]],
            [['title' => '辛い or あっさり?'], ['choice' => ['辛い', 'あっさり']]],
            [['title' => 'アクション or コメディ?'], ['choice' => ['アクション', 'コメディ']]],
            [['title' => '本 or 映画?'], ['choice' => ['本', '映画']]],
            [['title' => '公共交通機関 or 個人の車?'], ['choice' => ['公共交通機関', '個人の車']]],
            [['title' => 'サッカー or バスケットボール?'], ['choice' => ['サッカー', 'バスケットボール']]],
            [['title' => '寿司 or タコス?'], ['choice' => ['寿司', 'タコス']]],
            [['title' => '都会 or 田舎?'], ['choice' => ['都会', '田舎']]],
            [['title' => 'PC or ゲーム機?'], ['choice' => ['PC', 'ゲーム機']]],
            [['title' => '紅茶 or コーヒー?'], ['choice' => ['紅茶', 'コーヒー']]],
            [['title' => '音楽 or ポッドキャスト?'], ['choice' => ['音楽', 'ポッドキャスト']]],
            [['title' => 'Netflix or Hulu?'], ['choice' => ['Netflix', 'Hulu']]],
        ];

        foreach ($questionnaireList as $index => $questionnaireItem) {
            $targetId = $index + 1;
            // アンケート
            Questionnaire::factory()->create($questionnaireItem[0]);

            // アンケート選択肢
            QreChoice::factory()->count(2)->state(new Sequence(
                [
                    'questionnaire_id' => $targetId,
                    'body' => $questionnaireItem[1]['choice'][0],
                    'display_order' => 1
                ],
                [
                    'questionnaire_id' => $targetId,
                    'body' => $questionnaireItem[1]['choice'][1],
                    'display_order' => 2
                ],
            ))->create();
        }

        // アンケートにタグを追加
        $questionnaires = Questionnaire::all();
        foreach ($questionnaires as $questionnaire) {
            $tags = Tag::all()->pluck('id')->toArray();
            // questionnaire_tagテーブルへカテゴリデータ追加
            $randomNumArray = range(1, count($tags));
            shuffle($randomNumArray);
            if ($targetId === 0) {
                dd($questionnaire);
            }
            $questionnaire->tags()->attach($randomNumArray[0]);
            $questionnaire->tags()->attach($randomNumArray[1]);
        }
    }
}
