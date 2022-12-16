<?php

declare(strict_types=1);

namespace App\Adapter\Presenter\Questionnaire;

use App\Models\Questionnaire;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

/**
 * GetRankingListPresenter class
 */
final class GetRankingListPresenter
{
    /**
     * コンストラクタ
     *
     * @param LengthAwarePaginator $questionnaires
     */
    public function __construct(private LengthAwarePaginator $questionnaires)
    {
    }

    /**
     * 配列に変換
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'questionnaires' => $this->questionnaires->getCollection()
                ->map(fn(Questionnaire $questionnaire) => [
                    'id' => $questionnaire->id,
                    'title' => $questionnaire->title,
                    'description' => $questionnaire->description,
                    'thumbnailUrl' => $questionnaire->thumbnail_url,
                    'createdAt' => (new Carbon($questionnaire->created_at))->toDateTimeString(),
                    'voteCountAll' => $questionnaire->qre_votes_count,
                    'user' => [
                        'id' => $questionnaire->user->id,
                        'name' => $questionnaire->user->name
                    ]
                ])
                ->toArray(),
            'pager' => [
                'currentPage' => $this->questionnaires->currentPage(),
                'lastPage' => $this->questionnaires->lastPage(),
                'allCount' => $this->questionnaires->total(),
            ]
        ];
    }
}
