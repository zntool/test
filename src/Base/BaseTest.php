<?php

namespace ZnTool\Test\Base;

use ZnCore\Base\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Domain\Helpers\EntityHelper;
use ZnTool\Test\Libs\FixtureLoader;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{

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

    protected function assertUnprocessibleEntityException($expected, UnprocessibleEntityException $e, bool $debug = false)
    {
        $errorCollection = $e->getErrorCollection();
        $arr = EntityHelper::collectionToArray($errorCollection);
        $this->assertArraySubset($expected, $arr);
    }

}