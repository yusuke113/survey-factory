<?php

declare(strict_types=1);

namespace Domain\Repository;

use App\Models\Questionnaire;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * QreVoteRepositoryInterface interface
 */
interface QreVoteRepositoryInterface
{
    /**
     * アンケート投票を登録する
     *
     * @param int $questionnaireId
     * @param int $qreChoiceId
     * @param string $userToken
     * @return void
     */
    public function save(
        int $questionnaireId,
        int $qreChoiceId,
        string $userToken,
    ): void;
}
