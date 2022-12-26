<?php

declare(strict_types=1);

namespace Domain\Constant\Questionnaire;

/**
 * ThumbnailUrl の定数を格納
 */
final class ThumbnailUrl
{
    /**
     * ThumbnailUrlの最大文字数
     *
     * @var int
     */
    public const MAX_LENGTH = 255;

    /**
     * ThumbnailUrlのバリデーションパターン
     *
     * @var string
     *
     * phpcs:disable Generic.Files.LineLength.MaxExceeded
     */
    public const VALID_PATTERN = '/\Ahttps?:\/\/[\w\/:%#\$&\?\(\)~\.=\+\-]+\.(jpeg|jpg|png|JPEG|JPG|PNG)\z/';
}
