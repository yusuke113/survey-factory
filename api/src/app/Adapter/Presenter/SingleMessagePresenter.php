<?php

declare(strict_types=1);

namespace App\Adapter\Presenter;

/**
 * SingleMessagePresenter Class
 */
class SingleMessagePresenter
{
    /**
     * コンストラクタ
     *
     * @param string $message
     */
    public function __construct(protected string $message)
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
            'message' => $this->message,
        ];
    }
}
