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
     * @param string $type
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function search(string $type, int $page, int $limit): LengthAwarePaginator;

    /**
     * アンケートIDからアンケートを取得する
     *
     * @param int $questionnaireId
     * @return Questionnaire|null
     */
    public function findById(int $questionnaireId): ?Questionnaire;

    /**
     * アンケートを登録する
     *
     * @param int $userId
     * @param string $title
     * @param string $description
     * @param string|null $thumbnailUrl
     * @return void
     */
    public function save(int $userId, string $title, string $description, ?string $thumbnailUrl): void;
}
