<?php

namespace ZnTool\Test\Base;

use PHPUnit\Framework\TestCase;
use ZnTool\Test\Libs\FixtureLoader;
use ZnTool\Test\Traits\AssertTrait;

abstract class BaseTest extends TestCase
{

    use AssertTrait;

    protected function fixtures(): array
    {
        return [];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $fixtures = $this->fixtures();
        if ($fixtures) {
            $fixtureLoader = new FixtureLoader;
            $fixtureLoader->load($fixtures);
        }
    }
}