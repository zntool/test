<?php

namespace ZnTool\Test\Base;

use ZnCore\Base\Develop\Helpers\DeprecateHelper;
use ZnTool\Test\Asserts\RestApiAssert;
use Psr\Http\Message\ResponseInterface;

DeprecateHelper::hardThrow();

abstract class BaseRestApiTest extends BaseRestTest
{

    protected function getRestAssert(ResponseInterface $response = null): RestApiAssert
    {
        return new RestApiAssert($response);
    }

}
