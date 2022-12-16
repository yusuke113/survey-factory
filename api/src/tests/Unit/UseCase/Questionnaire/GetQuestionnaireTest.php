<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Questionnaire;

use App\Models\QreChoice;
use App\Models\QreVote;
use App\Models\Questionnaire;
use App\Models\User;
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
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app()->make(GetQuestionnaire::class);

        User::factory()->createMany(self::USERS);
        Questionnaire::factory()->create(self::QUESTIONNAIRE);
        QreChoice::factory()->createMany(self::QRE_CHOICES);
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
}