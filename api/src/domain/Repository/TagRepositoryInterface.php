<?php

declare(strict_types=1);

namespace Domain\Repository;

use App\Models\Tag;

/**
 * TagRepositoryInterface interface
 */
interface TagRepositoryInterface
{
    /**
     * タグ名からタグを取得する
     *
     * @param string $name
     * @return Tag|null
     */
    public function findByName(string $name): ?Tag;

    /**
     * タグを登録する
     *
     * @param string $name
     * @return Tag
     */
    public function save(string $name): Tag;
}
