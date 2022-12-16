<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\Schema;

/**
 * 外部キー制約一時無効化措置
 *
 * DisableForeignKeyConstraints trait
 */
trait DisableForeignKeyConstraints
{
    /**
     * 外部キー制約無効化
     *
     * @return void
     */
    protected function disableForeignKeyConstraints(): void
    {
        Schema::disableForeignKeyConstraints();
    }

    /**
     * 外部キー制約有効化
     *
     * @return void
     */
    protected function enableForeignKeyConstraints(): void
    {
        Schema::enableForeignKeyConstraints();
    }
}
