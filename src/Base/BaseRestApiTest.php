<?php

namespace ZnTool\Test\Base;

use ZnTool\Test\Asserts\RestApiAssert;
use Psr\Http\Message\ResponseInterface;

abstract class BaseRestApiTest extends BaseRestTest
{

    protected function getRestAssert(ResponseInterface $response = null): RestApiAssert
    {
        return new RestApiAssert($response);
    }

}