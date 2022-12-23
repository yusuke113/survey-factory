<?php

declare(strict_types=1);

namespace Domain\UseCase\Questionnaire;

use App\Adapter\Presenter\Questionnaire\GetRankingListPresenter;
use Domain\Repository\QuestionnaireRepositoryInterface;

/**
 * GetRankingList class
 */
final class GetRankingList
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
     * @param string $type
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function __invoke(
        string $type,
        int $page,
        int $limit,
    ): array {
        $questionnaires = $this->questionnaireRepository->search($type, $page, $limit);

        return (new GetRankingListPresenter($questionnaires))->toArray();
    }
}
