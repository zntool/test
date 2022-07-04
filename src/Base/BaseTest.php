<?php

namespace ZnTool\Test\Base;

use ZnTool\Test\Libs\FixtureLoader;
use ZnTool\Test\Traits\AssertTrait;

abstract class BaseTest extends BaseTestCase
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