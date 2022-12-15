<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (method_exists($this, 'disableForeignKeyConstraints')) {
            $this->disableForeignKeyConstraints();
        }
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        if (method_exists($this, 'enableForeignKeyConstraints')) {
            $this->enableForeignKeyConstraints();
        }
        parent::tearDown();
    }
}
