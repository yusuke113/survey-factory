<?php

declare(strict_types=1);

namespace Domain\UseCase\Questionnaire;

use App\Adapter\Presenter\SingleMessagePresenter;
use Domain\Exception\NotFoundException;
use Domain\Repository\QuestionnaireRepositoryInterface;
use Domain\Repository\UserRepositoryInterface;

/**
 * StoreQuestionnaire class
 */
final class StoreQuestionnaire
{
    /**
     * コンストラクタ
     *
     * @param QuestionnaireRepositoryInterface $questionnaireRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private QuestionnaireRepositoryInterface $questionnaireRepository,
        private UserRepositoryInterface $userRepository,
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
        $user = $this->userRepository->findById($userId);

        if (is_null($user)) {
            throw new NotFoundException(__('exception.not_found.attributes.user'));
        }

        $this->questionnaireRepository->save(
            $userId,
            $title,
            $description,
            $thumbnailUrl,
            $qreChoices,
            $tags
        );

        return (new SingleMessagePresenter(__('expectation.created.message')))->toArray();
    }
}
