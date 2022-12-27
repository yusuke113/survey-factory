<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreRequest;
use Domain\UseCase\Tag\StoreTag;
use Illuminate\Http\JsonResponse;

/**
 * Store class
 */
final class Store extends Controller
{
    /**
     * タグを登録する
     *
     * @param StoreTag $useCase
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(
        StoreTag $useCase,
        StoreRequest $request
    ): JsonResponse {
        return response()->json($useCase($request->input('name')));
    }
}
