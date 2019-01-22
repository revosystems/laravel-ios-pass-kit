<?php

namespace Tests\Unit;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class PassesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadEnv();
    }

    /**
     * @return array
     */
    private function loadEnv()
    {
        return (new Dotenv(__DIR__, "../../.env"))->load();
    }

    /** @test */
    public function can_register_a_device()
    {
    }
}
