<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Questionnaire;

use App\Models\Questionnaire;
use App\Models\Tag;
use App\Models\User;
use Domain\UseCase\Questionnaire\StoreQuestionnaire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class StoreQuestionnaireTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザーのテストデータ
     * @var array
     */
    private const USER = [
        'id' => 1,
        'name' => 'テストユーザー1'
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
            'name' => 'ゲーム',
        ],
        [
            'id' => 3,
            'name' => 'Youtube',
        ],
    ];

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app()->make(StoreQuestionnaire::class);

        User::factory()->create(self::USER);
        Tag::factory()->createMany(self::TAGS);
    }

    /**
     * @test
     * @dataProvider アンケートを新規登録できること_provider
     *
     * @return void
     */
    public function アンケートを新規登録できること($input, $expected): void
    {
        ($this->useCase)(...$input);

        $actual = Questionnaire::latest()->first()->toArray();

        $this->assertSame(
            $expected,
            Arr::only($actual, array_keys($expected))
        );
    }

    /**
     * @return array
     */
    public function アンケートを新規登録できること_provider(): array
    {
        return [
            '正常系' => [
                '入力値' => [
                    'userId' => 1,
                    'title' => 'アンケートタイトルA',
                    'description' => 'アンケート説明文A',
                    'thumbnailUrl' => 'https://test.jpg',
                    'qreChoices' => [
                        [
                          'body' => '選択肢内容A',
                          'displayOrder' => 1
                        ],
                        [
                          'body' => '選択肢内容B',
                          'displayOrder' => 2,
                        ],
                    ],
                    'tags' => [
                        [
                            'id' => 1,
                            'name' => 'アニメ',
                        ],
                        [
                            'id' => 2,
                            'name' => 'ゲーム',
                        ],
                    ],
                ],
                '期待値' => [
                    'user_id' => 1,
                    'title' => 'アンケートタイトルA',
                    'description' => 'アンケート説明文A',
                    'thumbnail_url' => 'https://test.jpg',
                ],
            ],
            'サムネイル画像がない場合' => [
                '入力値' => [
                    'userId' => 1,
                    'title' => 'アンケートタイトルA',
                    'description' => 'アンケート説明文A',
                    'thumbnailUrl' => null,
                    'qreChoices' => [
                        [
                          'body' => '選択肢内容A',
                          'displayOrder' => 1
                        ],
                        [
                          'body' => '選択肢内容B',
                          'displayOrder' => 2,
                        ],
                    ],
                    'tags' => [
                        [
                            'id' => 1,
                            'name' => 'アニメ',
                        ],
                        [
                            'id' => 2,
                            'name' => 'ゲーム',
                        ],
                    ],
                ],
                '期待値' => [
                    'user_id' => 1,
                    'title' => 'アンケートタイトルA',
                    'description' => 'アンケート説明文A',
                    'thumbnail_url' => null,
                ],
            ],
        ];
    }
}