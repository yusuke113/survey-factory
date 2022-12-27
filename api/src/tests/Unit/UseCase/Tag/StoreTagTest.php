<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\Tag;

use App\Models\Tag;
use Domain\UseCase\Tag\StoreTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class StoreTagTest extends TestCase
{
    use RefreshDatabase;

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
        [
            'id' => 4,
            'name' => 'ポケモン',
        ],
    ];

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app()->make(StoreTag::class);

        Tag::factory()->createMany(self::TAGS);
    }

    /**
     * @test
     * @dataProvider 指定されたタグ名DBに存在しない場合タグを新規登録できること_provider
     *
     * @return void
     */
    public function 指定されたタグ名DBに存在しない場合タグを新規登録できること($input, $expected): void
    {
        ($this->useCase)(...$input);

        $actual = Tag::latest()->first()->toArray();

        $this->assertSame(
            $expected,
            Arr::only($actual, array_keys($expected))
        );
    }

    /**
     * @return array
     */
    public function 指定されたタグ名DBに存在しない場合タグを新規登録できること_provider(): array
    {
        return [
            '正常系' => [
                '入力値' => [
                    'name' => "ファッション",
                ],
                '期待値' => [
                    'name' => 'ファッション',
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider タグの新規登録後に保存したタグ情報が取得できること_provider
     *
     * @return void
     */
    public function タグの新規登録後に保存したタグ情報が取得できること($input, $expected): void
    {
        $actual = ($this->useCase)(...$input);

        $this->assertSame(
            $expected,
            Arr::only($actual, array_keys($expected))
        );
    }

    /**
     * @return array
     */
    public function タグの新規登録後に保存したタグ情報が取得できること_provider(): array
    {
        return [
            '正常系' => [
                '入力値' => [
                    'name' => "ファッション",
                ],
                '期待値' => [
                    'name' => 'ファッション',
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider 指定されたタグ名がDBに存在する場合そのタグ情報を取得できること_provider
     *
     * @return void
     */
    public function 指定されたタグ名がDBに存在する場合そのタグ情報を取得できること($input, $expected): void
    {
        $actual = ($this->useCase)(...$input);

        $this->assertSame(
            $expected,
            Arr::only($actual, array_keys($expected))
        );
    }

    /**
     * @return array
     */
    public function 指定されたタグ名がDBに存在する場合そのタグ情報を取得できること_provider(): array
    {
        return [
            'タグ名に「アニメ」を指定' => [
                '入力値' => [
                    'name' => "アニメ",
                ],
                '期待値' => [
                    'id' => 1,
                    'name' => 'アニメ',
                ],
            ],
            'タグ名に「ポケモン」を指定' => [
                '入力値' => [
                    'name' => "ポケモン",
                ],
                '期待値' => [
                    'id' => 4,
                    'name' => 'ポケモン',
                ],
            ],
        ];
    }
}
