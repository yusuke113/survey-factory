<?php

declare(strict_types=1);

namespace Domain\UseCase\Questionnaire;

use App\Adapter\Presenter\Questionnaire\GetQuestionnairePresenter;
use Domain\Exception\NotFoundException;
use Domain\Repository\QuestionnaireRepositoryInterface;

/**
 * GetQuestionnaire class
 */
final class GetQuestionnaire
{
    /**
     * コンストラクタ
     *
     * @param QuestionnaireRepositoryInterface $questionnaireRepository
     */
    public function __construct(
        private QuestionnaireRepositoryInterface $questionnaireRepository
    ) {
    }

    /**
     * @param int $questionnaireId
     * @return array
     */
    public function __invoke(int $questionnaireId): array
    {
        $questionnaire = $this->questionnaireRepository->findById($questionnaireId);

        if (is_null($questionnaire)) {
            throw new NotFoundException(__('exception.not_found.attributes.questionnaire'));
        }

        $qreChoices = $questionnaire->qreChoices()->withCount('qreVotes')->get();

        return (new GetQuestionnairePresenter($questionnaire, $qreChoices))->toArray();
    }
}
