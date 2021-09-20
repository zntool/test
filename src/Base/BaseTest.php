<?php

namespace ZnTool\Test\Base;

use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnTool\Test\Libs\FixtureLoader;
use PHPUnit\Framework\TestCase;
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