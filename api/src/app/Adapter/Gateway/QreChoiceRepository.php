<?php

declare(strict_types=1);

namespace App\Adapter\Gateway;

use App\Models\QreChoice;
use Domain\Repository\QreChoiceRepositoryInterface;

/**
 * QreChoiceRepository class
 */
final class QreChoiceRepository implements QreChoiceRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findRelatedToQuestionnaireById(int $questionnaireId, int $qreChoiceId): ?QreChoice
    {
        return QreChoice::where([
            'id' => $qreChoiceId,
            'questionnaire_id' => $questionnaireId,
        ])->first();
    }
}
