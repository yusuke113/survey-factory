<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Questionnaire;

use App\Models\QreChoice;
use App\Models\QreVote;
use App\Models\Questionnaire;
use App\Models\User;
use Domain\UseCase\Questionnaire\GetRankingList;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DisableForeignKeyConstraints;
use Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class GetRankingListTest extends TestCase
{
    use RefreshDatabase, DisableForeignKeyConstraints;

    /**
     * ユーザーもテストデータ
     * @var array
     */
    private const USERS = [
        [
            'id' => 1,
            'name' => 'テストユーザー1'
        ],
        [
            'id' => 2,
            'name' => 'テストユーザー2'
        ],
    ];

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app()->make(GetRankingList::class);

        User::factory()->createMany(self::USERS);
    }

     /**
     * @test
     * @dataProvider アンケート投票数ランキング一覧を取得できること_provider
     *
     * @return void
     */
    public function アンケート投票数ランキング一覧を取得できること($questionnaires, $input, $expected)
    {
        // アンケートと選択肢のテストデータを作成
        foreach ($questionnaires as $questionnaire) {
            Questionnaire::factory()
                ->has(QreChoice::factory(2)->state(new Sequence(
                    [
                        'body' => '選択肢1',
                        'display_order' => 1
                    ],
                    [
                        'body' => '選択肢2',
                        'display_order' => 2
                    ]
                )))
            ->create($questionnaire);
        }

        // アンケート投票のテストデータを作成
        QreVote::factory(30)->create(
            [
                'questionnaire_id' => 11,
                'qre_choices_id' => Questionnaire::find(11)->qreChoices->first()->id,
            ]
        );
        QreVote::factory(50)->create(
            [
                'questionnaire_id' => 22,
                'qre_choices_id' => Questionnaire::find(22)->qreChoices->first()->id,
            ]
        );

        $actual = ($this->useCase)(...$input)['questionnaires'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function アンケート投票数ランキング一覧を取得できること_provider()
    {
        return [
            '正常系' => [
                '登録値' => [
                    [
                        'id' => 11,
                        'user_id' => 1,
                        'title' => 'アンケートタイトル1',
                        'description' => 'アンケート説明文1',
                        'thumbnail_url' => 'https://chiikawa-info.jp/images/pic06.jpg',
                        'created_at' => '2022-11-01 00:00:00',
                    ],
                    [
                        'id' => 22,
                        'user_id' => 2,
                        'title' => 'アンケートタイトル2',
                        'description' => 'アンケート説明文2',
                        'thumbnail_url' => 'https://chiikawa-info.jp/images/pic06.jpg',
                        'created_at' => '2022-10-01 00:00:00',
                    ],
                ],
                '入力値' => [
                    'case' => 'vote',
                    'page' => 1,
                    'limit' => 30,
                ],
                '期待値' => [
                    [
                        'id' => 22,
                        'title' => 'アンケートタイトル2',
                        'description' => 'アンケート説明文2',
                        'thumbnail_url' => 'https://chiikawa-info.jp/images/pic06.jpg',
                        'created_at' => '2022-10-01 00:00:00',
                        'voteCountAll' => 50,
                        "user" => [
                            "id" => 2,
                            "name" => 'テストユーザー2'
                        ]
                    ],
                    [
                        'id' => 11,
                        'title' => 'アンケートタイトル1',
                        'description' => 'アンケート説明文1',
                        'thumbnail_url' => 'https://chiikawa-info.jp/images/pic06.jpg',
                        'created_at' => '2022-11-01 00:00:00',
                        'voteCountAll' => 30,
                        "user" => [
                            "id" => 1,
                            "name" => 'テストユーザー1'
                        ]
                    ],
                ]
            ]
        ];
    }
}
