<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\QuestionnaireFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * モデルの新ファクトリ・インスタンスの生成
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return QuestionnaireFactory::new();
    }

    /**
     * ユーザー
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * アンケート選択肢
     *
     * @return HasMany
     */
    public function qreChoices(): HasMany
    {
        return $this->hasMany(QreChoice::class);
    }

    /**
     * アンケート投票
     *
     * @return HasMany
     */
    public function qreVotes(): HasMany
    {
        return $this->hasMany(QreVote::class);
    }
}
