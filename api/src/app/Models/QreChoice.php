<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\QreChoiceFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QreChoice extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * モデルの新ファクトリ・インスタンスの生成
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return QreChoiceFactory::new();
    }

    /**
     * アンケート選択肢
     *
     * @return BelongsTo
     */
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * アンケート投票
     *
     * @return BelongsTo
     */
    public function qreVote(): BelongsTo
    {
        return $this->belongsTo(QreVote::class);
    }
}
