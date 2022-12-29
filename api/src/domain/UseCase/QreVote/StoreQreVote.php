<?php

declare(strict_types=1);

namespace Domain\UseCase\QreVote;

use App\Adapter\Presenter\SingleMessagePresenter;
use Domain\Exception\NotFoundException;
use Domain\Repository\QreChoiceRepositoryInterface;
use Domain\Repository\QreVoteRepositoryInterface;
use Domain\Repository\QuestionnaireRepositoryInterface;

/**
 * StoreQreVote class
 */
final class StoreQreVote
{
    /**
     * コンストラクタ
     *
     * @param QuestionnaireRepositoryInterface $questionnaireRepository
     * @param QreChoiceRepositoryInterface $qreChoiceRepository
     * @param QreVoteRepositoryInterface $qreVoteRepository
     */
    public function __construct(
        private QuestionnaireRepositoryInterface $questionnaireRepository,
        private QreChoiceRepositoryInterface $qreChoiceRepository,
        private QreVoteRepositoryInterface $qreVoteRepository
    ) {
    }

    /**
     * @param int $questionnaireId
     * @param int $qreChoiceId
     * @param string $userToken
     * @return array
     */
    public function __invoke(
        int $questionnaireId,
        int $qreChoiceId,
        string $userToken,
    ): array {
        $questionnaire = $this->questionnaireRepository->findById($questionnaireId);

        if (is_null($questionnaire)) {
            throw new NotFoundException(__('exception.not_found.attributes.questionnaire'));
        }

        $qreChoice = $this->qreChoiceRepository->findRelatedToQuestionnaireById($questionnaireId, $qreChoiceId);

        if (is_null($qreChoice)) {
            throw new NotFoundException(__('exception.not_found.attributes.qreChoice'));
        }

        $this->qreVoteRepository->save(
            $questionnaireId,
            $qreChoiceId,
            $userToken,
        );

        return (new SingleMessagePresenter(__('expectation.created.message')))->toArray();
    }
}
