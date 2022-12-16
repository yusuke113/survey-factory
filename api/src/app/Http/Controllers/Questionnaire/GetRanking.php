<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\GetRankingRequest;
use Domain\UseCase\Questionnaire\GetRankingList;
use Illuminate\Http\JsonResponse;

/**
 * GetRanking class
 */
final class GetRanking extends Controller
{
    /**
     * メアンケートランキング一覧を取得する
     *
     * @param GetRankingList $useCase
     * @param GetRankingRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        GetRankingList $useCase,
        GetRankingRequest $request
    ): JsonResponse {
        return response()->json($useCase(
            $request->input('case'),
            $request->int('page'),
            $request->int('limit')
        ));
    }
}
