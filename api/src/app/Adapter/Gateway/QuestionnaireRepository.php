<?php

declare(strict_types=1);

namespace App\Adapter\Gateway;

use App\Models\QreChoice;
use App\Models\Questionnaire;
use Domain\Repository\QuestionnaireRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * QuestionnaireRepository class
 */
final class QuestionnaireRepository implements QuestionnaireRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function search(?string $type, int $page, int $limit): LengthAwarePaginator
    {
        return $this->executeSearchQuery($type, $page, $limit);
    }

    /**
     * アンケートランキング一覧取得のクエリを実行する
     *
     * @param string|null $type
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    private function executeSearchQuery(?string $type, int $page, int $limit): LengthAwarePaginator
    {
        $sortType = '';
        $relationTable = '';

        switch ($type) {
            case 'vote':
                $sortType = 'qreVotes';
                $relationTable = 'qre_votes';
                break;
        }

        return Questionnaire::when(empty($sortType), function ($query) {
            // INFO: ランキング種別に指定がない場合（デフォルト： 新着順）
            return $query
                ->withCount('qreVotes')
                ->orderByDesc('created_at');
        }, function ($query) use ($sortType, $relationTable) {
            // INFO: ランキング種別に指定ありの場合
            return $query
                ->withCount($sortType)
                ->orderByDesc($relationTable . '_count');
        })
        ->with(['user'])
        ->paginate(
            perPage: $limit,
            page: $page
        );
    }

    /**
     * @inheritDoc
     */
    public function findById(int $questionnaireId): ?Questionnaire
    {
        return Questionnaire::withCount('qreVotes')->find($questionnaireId);
    }

    /**
     * @inheritDoc
     */
    public function save(
        int $userId,
        string $title,
        string $description,
        ?string $thumbnailUrl,
        array $qreChoices,
        array $tags
    ): void {
        $questionnaire = new Questionnaire();
        $questionnaire->uuid = (string) Str::uuid();
        $questionnaire->user_id = $userId;
        $questionnaire->title = $title;
        $questionnaire->description = $description;
        if (!is_null($thumbnailUrl)) {
            $questionnaire->thumbnail_url = $thumbnailUrl;
        }

        DB::beginTransaction();
        try {
            $questionnaire->save();
            $this->saveQreChoice($questionnaire->id, $qreChoices);
            $this->saveTag($questionnaire, $tags);
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
    }

    /**
     * アンケートの選択肢を登録する
     *
     * @param int $questionnaireId
     * @param array $inputQreChoices
     * @return void
     */
    private function saveQreChoice(
        int $questionnaireId,
        array $inputQreChoices
    ): void {
        // INFO: displayOrderの値の昇順で並び替え
        array_multisort(array_column($inputQreChoices, 'displayOrder'), SORT_ASC, $inputQreChoices);

        foreach ($inputQreChoices as $index => $inputQreChoice) {
            $qreChoice = new QreChoice();
            $qreChoice->uuid = (string) Str::uuid();
            $qreChoice->questionnaire_id = $questionnaireId;
            $qreChoice->body = $inputQreChoice['body'];
            $qreChoice->display_order = ++$index; // foreachの中で順番を振り直す
            $qreChoice->save();
        }
    }

    /**
     * アンケートのタグを登録する
     *
     * @param Questionnaire $questionnaire
     * @param array $tags
     * @return void
     */
    private function saveTag(
        Questionnaire $questionnaire,
        array $tags
    ): void {
        // INFO: タグの数が3つより多い場合配列の上から3つに絞り込み
        if (count($tags) > 3) {
            $tags = array_slice($tags, 0, 3);
        }
        $tagIds = array_column($tags, 'id');
        $questionnaire->tags()->sync($tagIds);
    }
}
