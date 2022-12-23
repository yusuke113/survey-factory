<?php

declare(strict_types=1);

namespace App\Adapter\Gateway;

use App\Models\Questionnaire;
use Domain\Repository\QuestionnaireRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

/**
 * QuestionnaireRepository class
 */
final class QuestionnaireRepository implements QuestionnaireRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function search(string $type, int $page, int $limit): LengthAwarePaginator
    {
        return $this->executeSearchQuery($type, $page, $limit);
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
        ?string $thumbnailUrl
    ): void {
        $questionnaire = new Questionnaire();
        $questionnaire->uuid = (string) Str::uuid();
        $questionnaire->user_id = $userId;
        $questionnaire->title = $title;
        $questionnaire->description = $description;
        if(!is_null($thumbnailUrl)) {
            $questionnaire->thumbnail_url = $thumbnailUrl;
        }

        $questionnaire->save();
    }

    /**
     * アンケートランキング一覧取得のクエリを実行する
     *
     * @param string $type
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    private function executeSearchQuery(string $type, int $page, int $limit): LengthAwarePaginator
    {
        $sortType = '';
        $relationTable = '';

        switch ($type) {
            default:
                $sortType = 'qreVotes';
                $relationTable = 'qre_votes';
                break;
        }

        return Questionnaire::withCount($sortType)
            ->orderByDesc($relationTable . '_count')
            ->paginate(
                perPage: $limit,
                page: $page
            );
    }
}
