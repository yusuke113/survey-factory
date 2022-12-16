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
     * ユーザーのテストデータ
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
                        'thumbnailUrl' => 'https://chiikawa-info.jp/images/pic06.jpg',
                        'createdAt' => '2022-10-01 00:00:00',
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
                        'thumbnailUrl' => 'https://chiikawa-info.jp/images/pic06.jpg',
                        'createdAt' => '2022-11-01 00:00:00',
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

    /**
     * @test
     * @dataProvider アンケートを投票数の降順で取得できていること_provider
     *
     * @return void
     */
    public function アンケートを投票数の降順で取得できていること($questionnaires, $votes, $input, $expected)
    {
        // アンケートと選択肢のテストデータを作成
        foreach ($questionnaires as $questionnaire) {
            Questionnaire::factory()->create($questionnaire);
        }

        // アンケート投票のテストデータを作成
        foreach ($votes as $vote) {
            QreVote::factory($vote['count'])->create([
                'questionnaire_id' => $vote['questionnaireId'],
                'qre_choices_id' => $vote['qre_choices_id']
            ]);
        }

        $actual = array_column(($this->useCase)(...$input)['questionnaires'], 'id');

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function アンケートを投票数の降順で取得できていること_provider()
    {
        return [
            '正常系' => [
                'アンケート登録値' => [
                    [
                        'id' => 11,
                        'user_id' => 1,
                        'title' => 'アンケートタイトル1',
                    ],
                    [
                        'id' => 22,
                        'user_id' => 2,
                        'title' => 'アンケートタイトル2',
                    ],
                    [
                        'id' => 33,
                        'user_id' => 2,
                        'title' => 'アンケートタイトル2',
                    ],
                ],
                'アンケート投票登録値' => [
                    [
                        'questionnaireId' => 11,
                        'qre_choices_id' => 1,
                        'count' => 10,
                    ],
                    [
                        'questionnaireId' => 22,
                        'qre_choices_id' => 2,
                        'count' => 30,
                    ],
                    [
                        'questionnaireId' => 33,
                        'qre_choices_id' => 3,
                        'count' => 20,
                    ],
                ],
                '入力値' => [
                    'case' => 'vote',
                    'page' => 1,
                    'limit' => 30,
                ],
                '期待値' => [
                    22, 33, 11
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider アンケートランキング一覧のページャーが正しいこと_provider
     *
     * @return void
     */
    public function アンケートランキング一覧のページャーが正しいこと($questionnaireCount, $voteCount, $input, $expected)
    {
        // アンケートと選択肢のテストデータを作成
        Questionnaire::factory($questionnaireCount)->create();

        // アンケート投票のテストデータを作成
        $questionnaires = Questionnaire::all()->pluck('id')->toArray();
        QreVote::factory($voteCount)->create([
            'questionnaire_id' => array_rand($questionnaires, 1),
            'qre_choices_id' => rand(1, 10)
        ]);

        $actual = ($this->useCase)(...$input)['pager'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function アンケートランキング一覧のページャーが正しいこと_provider()
    {
        return [
            '合計30取得件数30のとき' => [
                'アンケート登録数' => 30,
                'アンケート投票登録値' => 10,
                '入力値' => [
                    'case' => 'vote',
                    'page' => 1,
                    'limit' => 30,
                ],
                '期待値' => [
                    "currentPage" => 1,
                    "lastPage" => 1,
                    "allCount" => 30
                ]
            ],
            '合計10取得件数5のとき' => [
                'アンケート登録数' => 10,
                'アンケート投票登録値' => 10,
                '入力値' => [
                    'case' => 'vote',
                    'page' => 1,
                    'limit' => 5,
                ],
                '期待値' => [
                    "currentPage" => 1,
                    "lastPage" => 2,
                    "allCount" => 10
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider 存在しないページ番号を指定しても例外が発生しないこと_provider
     *
     * @return void
     */
    public function 存在しないページ番号を指定しても例外が発生しないこと($questionnaireCount, $voteCount, $input)
    {
        // アンケートと選択肢のテストデータを作成
        Questionnaire::factory($questionnaireCount)->create();

        // アンケート投票のテストデータを作成
        $questionnaires = Questionnaire::all()->pluck('id')->toArray();
        QreVote::factory($voteCount)->create([
            'questionnaire_id' => array_rand($questionnaires, 1),
            'qre_choices_id' => rand(1, 10)
        ]);

        ($this->useCase)(...$input);

        $this->assertTrue(true);
    }

    /**
     * @return array
     */
    public function 存在しないページ番号を指定しても例外が発生しないこと_provider()
    {
        return [
            '存在しないページ番号を指定' => [
                'アンケート登録数' => 30,
                'アンケート投票登録値' => 10,
                '入力値' => [
                    'case' => 'vote',
                    'page' => 2,
                    'limit' => 30,
                ],
            ],
        ];
    }
}
