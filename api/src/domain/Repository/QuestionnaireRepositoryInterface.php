<?php

declare(strict_types=1);

namespace Domain\Repository;

use App\Models\Questionnaire;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * QuestionnaireRepositoryInterface interface
 */
interface QuestionnaireRepositoryInterface
{
    /**
     * アンケートランキング一覧を取得する
     *
     * @param string $case
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function search(string $case, int $page, int $limit): LengthAwarePaginator;

    /**
     * アンケートIDからアンケートを取得する
     *
     * @param int $questionnaireId
     * @return Questionnaire
     */
    public function findById(int $questionnaireId): Questionnaire;
}
