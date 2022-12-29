<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\QreVote;

use App\Models\QreChoice;
use App\Models\QreVote;
use App\Models\Questionnaire;
use Domain\Exception\DuplicateQreVoteException;
use Domain\Exception\NotFoundException;
use Domain\UseCase\QreVote\StoreQreVote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\DisableForeignKeyConstraints;
use Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class StoreQreVoteTest extends TestCase
{
    use RefreshDatabase, DisableForeignKeyConstraints;

    /**
     * 投票ユーザー
     * @var array
     */
    private const USER = [
        'userToken' => 'agNQYWjc6ypVT45stPkrMrOv'
    ];

    /**
     * アンケート
     * @var array
     */
    private const QUESTIONNAIRE = [
        'id' => 11,
        'user_id' => 1,
        'title' => 'アンケートA',
        'description' => 'アンケート説明文A',
    ];

    /**
     * アンケート選択肢
     * @var array
     */
    private const QRE_CHOICES = [
        [
            'id' => 1,
            'questionnaire_id' => 11,
            'body' => '選択肢A',
            'display_order' => 1,
        ],
        [
            'id' => 2,
            'questionnaire_id' => 11,
            'body' => '選択肢B',
            'display_order' => 2,
        ],
    ];

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = app()->make(StoreQreVote::class);

        Questionnaire::factory()->create(self::QUESTIONNAIRE);
        QreChoice::factory()->createMany(self::QRE_CHOICES);
    }

    /**
     * @test
     * @dataProvider アンケート投票を新規登録できること_provider
     *
     * @return void
     */
    public function アンケート投票を新規登録できること($input, $expected): void
    {
        ($this->useCase)(...$input);

        $actual = QreVote::latest()->first()->toArray();

        $this->assertSame(
            $expected,
            Arr::only($actual, array_keys($expected))
        );
    }

    /**
     * @return array
     */
    public function アンケート投票を新規登録できること_provider(): array
    {
        return [
            '正常系' => [
                '入力値' => [
                    'questionnaireId' => self::QUESTIONNAIRE['id'],
                    'qreChoiceId' => self::QRE_CHOICES[1]['id'],
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'questionnaire_id' => self::QUESTIONNAIRE['id'],
                    'qre_choice_id' => self::QRE_CHOICES[1]['id'],
                    'user_token' => self::USER['userToken'],
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider アンケート投票登録処理成功時のレスポンスが正しいこと_provider
     *
     * @return void
     */
    public function アンケート投票登録処理成功時のレスポンスが正しいこと($input, $expected): void
    {
        $actual = ($this->useCase)(...$input);

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function アンケート投票登録処理成功時のレスポンスが正しいこと_provider(): array
    {
        return [
            '正常系' => [
                '入力値' => [
                    'questionnaireId' => self::QUESTIONNAIRE['id'],
                    'qreChoiceId' => self::QRE_CHOICES[1]['id'],
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'message' => '登録が完了しました。',
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider 存在しないアンケートIDが指定された場合例外が発生すること_provider
     *
     * @return void
     */
    public function 存在しないアンケートIDが指定された場合例外が発生すること($input, $expected): void
    {
        $this->expectException($expected['exceptionClass']);
        $this->expectExceptionMessage($expected['message']);

        ($this->useCase)(...$input);
    }

    /**
     * @return array
     */
    public function 存在しないアンケートIDが指定された場合例外が発生すること_provider(): array
    {
        return [
            '存在しないアンケートIDを指定' => [
                '入力値' => [
                    'questionnaireId' => 33,
                    'qreChoiceId' => self::QRE_CHOICES[1]['id'],
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'exceptionClass' => NotFoundException::class,
                    'message' => 'アンケートが存在しません。',
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider 存在しないアンケート選択肢IDが指定された場合例外が発生すること_provider
     *
     * @return void
     */
    public function 存在しないアンケート選択肢IDが指定された場合例外が発生すること($qreChoice, $input, $expected): void
    {
        QreChoice::factory()->create($qreChoice);

        $this->expectException($expected['exceptionClass']);
        $this->expectExceptionMessage($expected['message']);

        ($this->useCase)(...$input);
    }

    /**
     * @return array
     */
    public function 存在しないアンケート選択肢IDが指定された場合例外が発生すること_provider(): array
    {
        return [
            '存在しないアンケート選択肢IDを指定' => [
                '登録値' => [
                    'id' => 11,
                    'questionnaire_id' => self::QUESTIONNAIRE['id'],
                ],
                '入力値' => [
                    'questionnaireId' => self::QUESTIONNAIRE['id'],
                    'qreChoiceId' => 33,
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'exceptionClass' => NotFoundException::class,
                    'message' => '選択肢が存在しません。',
                ],
            ],
            'アンケートに紐付かないアンケート選択肢IDを指定' => [
                '登録値' => [
                    'id' => 11,
                    'questionnaire_id' => 22,
                ],
                '入力値' => [
                    'questionnaireId' => self::QUESTIONNAIRE['id'],
                    'qreChoiceId' => 11,
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'exceptionClass' => NotFoundException::class,
                    'message' => '選択肢が存在しません。',
                ],
            ],
            '論理削除されたアンケート選択肢IDを指定' => [
                '登録値' => [
                    'id' => 11,
                    'questionnaire_id' => self::QUESTIONNAIRE['id'],
                    'deleted_at' => '2022-10-31 00:00:00',
                ],
                '入力値' => [
                    'questionnaireId' => self::QUESTIONNAIRE['id'],
                    'qreChoiceId' => 11,
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'exceptionClass' => NotFoundException::class,
                    'message' => '選択肢が存在しません。',
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider 既に投票済みのアンケートに紐づく選択肢IDが指定された場合例外が発生すること_provider
     *
     * @return void
     */
    public function 既に投票済みのアンケートに紐づく選択肢IDが指定された場合例外が発生すること($qreVote, $input, $expected): void
    {
        QreVote::factory()->create($qreVote);

        $this->expectException($expected['exceptionClass']);
        $this->expectExceptionMessage($expected['message']);

        ($this->useCase)(...$input);
    }

    /**
     * @return array
     */
    public function 既に投票済みのアンケートに紐づく選択肢IDが指定された場合例外が発生すること_provider(): array
    {
        return [
            '既に投票済みのアンケート選択肢IDを指定' => [
                '登録値' => [
                    'qre_choice_id' => self::QRE_CHOICES[1]['id'],
                    'questionnaire_id' => self::QUESTIONNAIRE['id'],
                    'user_token' => self::USER['userToken'],
                ],
                '入力値' => [
                    'questionnaireId' => self::QUESTIONNAIRE['id'],
                    'qreChoiceId' => self::QRE_CHOICES[1]['id'],
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'exceptionClass' => DuplicateQreVoteException::class,
                    'message' => '既に投票済みです。',
                ],
            ],
            '既に投票済みのアンケートに紐づく別の選択肢IDを指定' => [
                '登録値' => [
                    'qre_choice_id' => self::QRE_CHOICES[1]['id'],
                    'questionnaire_id' => self::QUESTIONNAIRE['id'],
                    'user_token' => self::USER['userToken'],
                ],
                '入力値' => [
                    'questionnaireId' => self::QUESTIONNAIRE['id'],
                    'qreChoiceId' => self::QRE_CHOICES[0]['id'],
                    'userToken' => self::USER['userToken'],
                ],
                '期待値' => [
                    'exceptionClass' => DuplicateQreVoteException::class,
                    'message' => '既に投票済みです。',
                ],
            ],
        ];
    }
}
