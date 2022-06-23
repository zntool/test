<?php

namespace ZnTool\Test\Traits;

use ZnCore\Domain\Entity\Helpers\CollectionHelper;
use ZnCore\Base\FileSystem\Helpers\FileStorageHelper;
use ZnCore\Base\Store\Helpers\StoreHelper;
use ZnCore\Base\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnTool\Test\Helpers\TestHelper;

trait AssertTrait
{

    protected function assertUnprocessibleEntityException($expected, UnprocessibleEntityException $e, bool $debug = false)
    {
        $errorCollection = $e->getErrorCollection();
        $arr = CollectionHelper::toArray($errorCollection);
        $this->assertArraySubset($expected, $arr);
    }

    protected function assertEntity($expected, object $entity)
    {
        $arr = EntityHelper::toArray($entity);
        $this->assertArraySubset($expected, $arr);
    }


    protected function assertArrayFromFile(string $exceptedFileName, array $actual, bool $rewrite = true)
    {
        $expected = StoreHelper::load($exceptedFileName);
        $expectedJson = json_encode($expected, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $actualJson = json_encode($actual, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if ($expectedJson !== $actualJson && TestHelper::isRewriteData() && $rewrite) {
            StoreHelper::save($exceptedFileName, $actual);
        }
        $this->assertEqualsArray($expected, $actual);

    }

    protected function assertFromFile(string $exceptedFileName, string $actual, bool $rewrite = true)
    {
        $expected = FileStorageHelper::load($exceptedFileName);
//        $expectedJson = json_encode($expected, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//        $actualJson = json_encode($actual, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        if ($expected !== $actual && TestHelper::isRewriteData() && $rewrite) {
            FileStorageHelper::save($exceptedFileName, $actual);
        }
        $this->assertEquals($expected, $actual);
    }

    protected function assertEqualsArray($expected, $actual)
    {
        $this->assertEquals(json_encode($expected, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), json_encode($actual, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}