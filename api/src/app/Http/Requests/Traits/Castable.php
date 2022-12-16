<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

/**
 * リクエストパラメータの型変換用トレイト
 *
 * Castable trait
 */
trait Castable
{
    /**
     * INT型に変換して取得
     *
     * @param string $parameter
     * @return int|null
     */
    public function int(string $parameter): ?int
    {
        $value = $this->input($parameter);
        return is_null($value) ? null : (int)$value;
    }
}
