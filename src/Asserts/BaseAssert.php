<?php

namespace ZnTool\Test\Asserts;

use PHPUnit\Framework\TestCase;
use ZnCore\Base\Libs\Arr\Helpers\ArrayHelper;
use ZnTool\Test\Helpers\RestHelper;

abstract class BaseAssert extends TestCase
{

    public function assertItemsByAttribute(array $values, string $attributeName, array $collection) {
        $actualIds = ArrayHelper::getColumn($collection, $attributeName);
        sort($values);
        sort($actualIds);
        $this->assertEquals($values, $actualIds);
    }
}
