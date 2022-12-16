<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questionnaire;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\ShowRequest;
use Domain\UseCase\Questionnaire\GetQuestionnaire;
use Illuminate\Http\JsonResponse;

/**
 * Show class
 */
final class Show extends Controller
{
    /**
     * 指定したアンケートIDに一致するアンケートの詳細を取得する
     *
     * @param GetQuestionnaire $useCase
     * @param int $questionnaireId
     * @param ShowRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        GetQuestionnaire $useCase,
        int $questionnaireId,
        ShowRequest $request
    ): JsonResponse {
        return response()->json($useCase($questionnaireId));
    }
}
