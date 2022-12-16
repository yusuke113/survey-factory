<?php

declare(strict_types=1);

namespace App\Adapter\Gateway;

use App\Models\Questionnaire;
use Domain\Repository\QuestionnaireRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * QuestionnaireRepository class
 */
final class QuestionnaireRepository implements QuestionnaireRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function search(string $case, int $page, int $limit): LengthAwarePaginator
    {
        return $this->executeSearchQuery($case, $page, $limit);
    }

    /**
     * アンケートランキング一覧取得のクエリを実行する
     *
     * @param string $case
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    private function executeSearchQuery(string $case, int $page, int $limit): LengthAwarePaginator
    {
        $sortType = '';
        $relationTable = '';

        switch ($case) {
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
