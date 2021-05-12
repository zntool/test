<?php

namespace ZnTool\Test\Base;

use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
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

    protected function assertEntity($expected, object $entity)
    {
        $arr = EntityHelper::toArray($entity);
        $this->assertArraySubset($expected, $arr);
    }
}