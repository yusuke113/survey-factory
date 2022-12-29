<?php

declare(strict_types=1);

namespace Domain\Exception;

use RuntimeException;

/**
 * DuplicateQreVoteException class
 */
class DuplicateQreVoteException extends RuntimeException
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct(message: __('exception.duplicate_qre_vote.message'));
    }
}
