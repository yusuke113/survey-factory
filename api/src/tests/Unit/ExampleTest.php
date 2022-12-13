<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // トークン生成の候補
        // $random = Str::random(24);
        // dd(bin2hex(openssl_random_pseudo_bytes(12)));
        $this->assertTrue(true);
    }
}
