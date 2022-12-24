<?php

declare(strict_types=1);

namespace Domain\Repository;

use App\Models\User;

/**
 * UserRepositoryInterface interface
 */
interface UserRepositoryInterface
{
    /**
     * ユーザーIDからユーザーを取得する
     *
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User;
}
