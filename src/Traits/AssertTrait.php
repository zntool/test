<?php

namespace ZnTool\Test\Traits;

use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;

trait AssertTrait
{

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