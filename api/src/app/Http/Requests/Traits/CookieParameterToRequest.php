<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

trait CookieParameterToRequest
{
    /**
     * Cookie含む、入力を全て取得する
     *
     * @param array|mixed|null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $all = parent::all($keys);

        foreach ($this->cookies as $key => $value) {
            $all[$key] = $value;
        }

        return $all;
    }

    /**
     * Cookieも含む、入力を取得する
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function input($key = null, $default = null)
    {
        if (array_key_exists($key, $this->cookie())) {
            return $this->cookie($key, $default);
        }
        return parent::input($key, $default);
    }
}
