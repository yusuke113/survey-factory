<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\QreVoteFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QreVote extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * モデルの新ファクトリ・インスタンスの生成
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return QreVoteFactory::new();
    }

    /**
     * アンケート
     *
     * @return BelongsTo
     */
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * アンケート選択肢
     *
     * @return BelongsTo
     */
    public function qreChoice(): BelongsTo
    {
        return $this->belongsTo(QreChoice::class);
    }
}
