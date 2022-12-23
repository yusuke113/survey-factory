<?php

declare(strict_types=1);

namespace Domain\UseCase\Questionnaire;

use App\Adapter\Presenter\SingleMessagePresenter;
use Domain\Repository\QuestionnaireRepositoryInterface;

/**
 * StoreQuestionnaire class
 */
final class StoreQuestionnaire
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
     * @param int $userId
     * @param string $title
     * @param string $description
     * @param string|null $thumbnailUrl
     * @param array $qreChoices
     * @param array $tags
     * @return array
     */
    public function __invoke(
        int $userId,
        string $title,
        string $description,
        ?string $thumbnailUrl,
        array $qreChoices,
        array $tags,
    ): array {
        $this->questionnaireRepository->save(
            $userId,
            $title,
            $description,
            $thumbnailUrl,
        );

        return (new SingleMessagePresenter(__('expectation.created.message')))->toArray();
    }
}
