<?php

namespace ZnTool\Test\Asserts;

use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnTool\Test\Base\BaseTestCase;
use ZnTool\Test\Helpers\RestHelper;

abstract class BaseAssert extends BaseTestCase
{

    public function assertItemsByAttribute(array $values, string $attributeName, array $collection)
    {
        $actualIds = ArrayHelper::getColumn($collection, $attributeName);
        sort($values);
        sort($actualIds);
        $this->assertEquals($values, $actualIds);
    }
}
