<?php

declare(strict_types=1);

namespace App\Adapter\Presenter\Questionnaire;

use App\Models\QreChoice;
use App\Models\Questionnaire;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * GetQuestionnairePresenter class
 */
final class GetQuestionnairePresenter
{
    /**
     * コンストラクタ
     *
     * @param Questionnaire $questionnaire
     * @param Collection $qreChoices
     */
    public function __construct(
        private Questionnaire $questionnaire,
        private Collection $qreChoices
    ) {
    }

    /**
     * 配列に変換
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'questionnaire' => [
                'id' => $this->questionnaire->id,
                'title' => $this->questionnaire->title,
                'description' => $this->questionnaire->description,
                'thumbnailUrl' => is_null($this->questionnaire->thumbnail_url)
                    ? ''
                    : $this->questionnaire->thumbnail_url,
                'createdAt' => (new Carbon($this->questionnaire->created_at))->toDateTimeString(),
                'voteCountAll' => $this->questionnaire->qre_votes_count,
                'user' => [
                    'id' => $this->questionnaire->user->id,
                    'name' => $this->questionnaire->user->name,
                ],
            ],
            'qreChoices' => $this->qreChoices
                ->map(fn(QreChoice $qreChoice) => [
                    "id" => $qreChoice->id,
                    "body" => $qreChoice->body,
                    "voteCount" => $qreChoice->qre_votes_count
                ])
                ->toArray(),
            'tags' => $this->questionnaire->tags
                ->map(fn(Tag $tag) => [
                    "id" => $tag->id,
                    "name" => $tag->name,
                ])
                ->toArray()
        ];
    }
}
