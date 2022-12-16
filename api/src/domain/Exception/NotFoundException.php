<?php

declare(strict_types=1);

namespace Domain\Exception;

use RuntimeException;

/**
 * NotFoundException class
 */
class NotFoundException extends RuntimeException
{
    /**
     * コンストラクタ
     *
     * @param string $attribute
     */
    public function __construct(string $attribute)
    {
        parent::__construct(message: __('exception.not_found.message', ['attribute' => $attribute]));
    }
}
