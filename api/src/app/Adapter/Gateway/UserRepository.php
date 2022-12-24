<?php

declare(strict_types=1);

namespace App\Adapter\Gateway;

use App\Models\User;
use Domain\Repository\UserRepositoryInterface;

/**
 * UserRepository class
 */
final class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findById(int $userId): ?User
    {
        return User::find($userId);
    }
}
