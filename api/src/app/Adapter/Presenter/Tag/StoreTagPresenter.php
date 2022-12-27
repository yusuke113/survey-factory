<?php

declare(strict_types=1);

namespace App\Adapter\Presenter\Tag;

use App\Models\Tag;

/**
 * StoreTagPresenter class
 */
final class StoreTagPresenter
{
    /**
     * コンストラクタ
     *
     * @param Tag $tag
     */
    public function __construct(private Tag $tag)
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
            'id' => $this->tag->id,
            'name' => $this->tag->name,
        ];
    }
}
