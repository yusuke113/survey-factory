<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\StoreRequest;
use Domain\UseCase\Questionnaire\StoreQuestionnaire;
use Illuminate\Http\JsonResponse;

/**
 * Store class
 */
final class Store extends Controller
{
    /**
     * アンケートを登録する
     *
     * @param StoreQuestionnaire $useCase
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        StoreQuestionnaire $useCase,
        StoreRequest $request
    ): JsonResponse {
        return response()->json($useCase(
            $request->int('userId'),
            $request->input('title'),
            $request->input('description'),
            $request->input('thumbnailUrl'),
            $request->input('qreChoices'),
            $request->input('tags'),
        ));
    }
}
