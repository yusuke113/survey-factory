<?php

declare(strict_types=1);

namespace Domain\Repository;

use App\Models\QreChoice;

/**
 * QreChoiceRepositoryInterface interface
 */
interface QreChoiceRepositoryInterface
{
    /**
     * アンケートIDとアンケート選択肢IDに紐づくアンケート選択肢を取得する
     *
     * @param int $questionnaireId
     * @param int $qreChoiceId
     * @return QreChoice|null
     */
    public function findRelatedToQuestionnaireById(int $questionnaireId, int $qreChoiceId): ?QreChoice;
}
