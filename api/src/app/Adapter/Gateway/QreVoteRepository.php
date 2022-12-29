<?php

declare(strict_types=1);

namespace App\Adapter\Gateway;

use App\Models\QreVote;
use Domain\Exception\DuplicateQreVoteException;
use Domain\Repository\QreVoteRepositoryInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * QreVoteRepository class
 */
final class QreVoteRepository implements QreVoteRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function save(
        int $questionnaireId,
        int $qreChoiceId,
        string $userToken
    ): void {
        $qreVote = new QreVote();
        $qreVote->uuid = (string) Str::uuid();
        $qreVote->questionnaire_id = $questionnaireId;
        $qreVote->qre_choice_id = $qreChoiceId;
        $qreVote->user_token = $userToken;

        try {
            $qreVote->save();
        } catch (RuntimeException $exception) {
            if ($exception->getCode() === Config::get('mysql.sql_state.integrity_constraint_violation')) {
                throw new DuplicateQreVoteException();
            }
            throw $exception;
        }
    }
}
