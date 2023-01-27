<?php

declare(strict_types=1);

namespace App\Http\Controllers\QreVote;

use App\Http\Controllers\Controller;
use App\Http\Requests\QreVote\StoreRequest;
use Domain\Exception\DuplicateQreVoteException;
use Domain\UseCase\QreVote\StoreQreVote;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as StatusCode;

/**
 * Store class
 */
final class Store extends Controller
{
    /**
     * アンケート投票を登録する
     *
     * @param StoreQreVote $useCase
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        StoreQreVote $useCase,
        StoreRequest $request
    ): JsonResponse {
        try {
            $response = $useCase(
                $request->int('questionnaireId'),
                $request->int('choiceId'),
                $request->input('user_token')
            );
        } catch (DuplicateQreVoteException $exception) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                ],
            );
        }

        return response()->json($response, StatusCode::HTTP_CREATED);
    }
}
