<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Questionnaire;

use App\Models\QreChoice;
use App\Models\QreVote;
use App\Models\Questionnaire;
use App\Models\Tag;
use App\Models\User;
use Domain\Exception\NotFoundException;
use Domain\UseCase\Questionnaire\GetQuestionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DisableForeignKeyConstraints;
use Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class GetQuestionnaireTest extends TestCase
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
     * アンケートのテストデータ
     * @var array
     */
    private const QUESTIONNAIRE = [
        'id' => 11,
        'user_id' => 1,
        'title' => 'アンケートタイトル1',
        'description' => 'アンケート説明文1',
        'thumbnail_url' => 'https://chiikawa-info.jp/images/pic06.jpg',
        'created_at' => '2022-10-01 00:00:00',
    ];

    /**
     * アンケート選択肢のテストデータ
     * @var array
     */
    private const QRE_CHOICES = [
        [
            'id' => 1,
            'questionnaire_id' => 11,
            'body' => '選択肢1',
            'display_order' => 1
        ],
        [
            'id' => 2,
            'questionnaire_id' => 11,
            'body' => '選択肢2',
            'display_order' => 2
        ],
    ];

    /**
     * アンケートのタグテストデータ
     * @var array
     */
    private const TAGS = [
        [
            'id' => 1,
            'name' => 'アニメ',
        ],
        [
            'id' => 2,
            'name' => 'Youtube',
        ],
        [
            'id' => 3,
            'name' => 'ゲーム',
        ],
    ];

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app()->make(GetQuestionnaire::class);

        User::factory()->createMany(self::USERS);
        Questionnaire::factory()->create(self::QUESTIONNAIRE);
        QreChoice::factory()->createMany(self::QRE_CHOICES);
        Tag::factory()->createMany(self::TAGS);
    }

    /**
     * @test
     * @dataProvider 指定したアンケートIDに一致するアンケートの詳細を取得できること_provider
     *
     * @return void
     */
    public function 指定したアンケートIDに一致するアンケートの詳細を取得できること(
        $voteCount1,
        $voteCount2,
        $input,
        $expected
    ) {
        // アンケート投票のテストデータを作成
        QreVote::factory($voteCount1)->create(
            [
                'questionnaire_id' => 11,
                'qre_choice_id' => 1,
            ]
        );
        QreVote::factory($voteCount2)->create(
            [
                'questionnaire_id' => 11,
                'qre_choice_id' => 2,
            ]
        );

        $actual = ($this->useCase)($input)['questionnaire'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function 指定したアンケートIDに一致するアンケートの詳細を取得できること_provider()
    {
        return [
            '正常系' => [
                '選択肢1への投票数' => 20,
                '選択肢2への投票数' => 30,
                '入力値' => 11,
                '期待値' => [
                    'id' => 11,
                    'title' => 'アンケートタイトル1',
                    'description' => 'アンケート説明文1',
                    'thumbnailUrl' => 'https://chiikawa-info.jp/images/pic06.jpg',
                    'createdAt' => '2022-10-01 00:00:00',
                    'voteCountAll' => 50,
                    "user" => [
                        "id" => 1,
                        "name" => 'テストユーザー1'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider 指定したアンケートIDに一致するアンケート選択肢の詳細を取得できること_provider
     *
     * @return void
     */
    public function 指定したアンケートIDに一致するアンケート選択肢の詳細を取得できること(
        $voteCount1,
        $voteCount2,
        $input,
        $expected
    ) {
        // アンケート投票のテストデータを作成
        QreVote::factory($voteCount1)->create(
            [
                'questionnaire_id' => 11,
                'qre_choice_id' => 1,
            ]
        );
        QreVote::factory($voteCount2)->create(
            [
                'questionnaire_id' => 11,
                'qre_choice_id' => 2,
            ]
        );

        $actual = ($this->useCase)($input)['qreChoices'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function 指定したアンケートIDに一致するアンケート選択肢の詳細を取得できること_provider()
    {
        return [
            '正常系' => [
                '選択肢1への投票数' => 20,
                '選択肢2への投票数' => 30,
                '入力値' => 11,
                '期待値' => [
                    [
                        "id" => 1,
                        "body" => '選択肢1',
                        "voteCount" => 20,
                    ],
                    [
                        "id" => 2,
                        "body" => '選択肢2',
                        "voteCount" => 30,
                    ],
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider 指定したアンケートIDに一致するアンケートに紐づくタグを取得できること_provider
     *
     * @return void
     */
    public function 指定したアンケートIDに一致するアンケートに紐づくタグを取得できること(
        $input,
        $expected
    ) {
        // アンケートへタグの紐付け
        $questionnaire = Questionnaire::first();
        $questionnaire->tags()->attach(1);
        $questionnaire->tags()->attach(2);

        $actual = ($this->useCase)($input)['tags'];

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function 指定したアンケートIDに一致するアンケートに紐づくタグを取得できること_provider()
    {
        return [
            'アンケートID11を指定' => [
                '入力値' => 11,
                '期待値' => [
                    [
                        "id" => 1,
                        "name" => 'アニメ',
                    ],
                    [
                        "id" => 2,
                        "name" => 'Youtube',
                    ],
                ]
            ],
        ];
    }

    /**
     * @test
     * @dataProvider 存在しないアンケートIDを指定した場合例外が発生すること_provider
     *
     * @return void
     */
    public function 存在しないアンケートIDを指定した場合例外が発生すること($input, $expected)
    {
        $this->expectException($expected['exception_class']);
        $this->expectExceptionMessage($expected['message']);

        ($this->useCase)($input);
    }

    /**
     * @return array
     */
    public function 存在しないアンケートIDを指定した場合例外が発生すること_provider()
    {
        return [
            '正常系' => [
                '入力値' => 99,
                '期待値' => [
                    'exception_class' => NotFoundException::class,
                    'message' => 'アンケートが存在しません。',
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider 論理削除されたアンケートIDを指定した場合例外が発生すること_provider
     *
     * @return void
     */
    public function 論理削除されたアンケートIDを指定した場合例外が発生すること($questionnaire, $input, $expected)
    {
        Questionnaire::factory()->create($questionnaire);

        $this->expectException($expected['exception_class']);
        $this->expectExceptionMessage($expected['message']);

        ($this->useCase)($input);
    }

    /**
     * @return array
     */
    public function 論理削除されたアンケートIDを指定した場合例外が発生すること_provider()
    {
        return [
            '正常系' => [
                '論理削除されたアンケート' => [
                    'id' => 55,
                    'deleted_at' => '2022-10-01 00:00:00',
                ],
                '入力値' => 55,
                '期待値' => [
                    'exception_class' => NotFoundException::class,
                    'message' => 'アンケートが存在しません。',
                ]
            ]
        ];
    }
}
