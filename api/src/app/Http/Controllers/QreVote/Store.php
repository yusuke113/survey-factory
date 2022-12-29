<?php

declare(strict_types=1);

namespace App\Http\Controllers\QreVote;

use App\Http\Controllers\Controller;
use App\Http\Requests\QreVote\StoreRequest;
use Domain\UseCase\QreVote\StoreQreVote;
use Illuminate\Http\JsonResponse;

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
        return response()->json($useCase(
            $request->int('questionnaireId'),
            $request->int('choiceId'),
            $request->input('userToken'),
        ));
    }
}
