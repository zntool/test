<?php

namespace ZnTool\Test\Asserts;

use ZnCore\Base\Libs\Arr\Helpers\ArrayHelper;
use ZnTool\Test\Helpers\RestHelper;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

abstract class RestAssert extends BaseAssert
{

    protected $response;
    protected $rawBody;
    protected $body;

    public function __construct(ResponseInterface $response = null)
    {
        $this->response = $response;
        $this->rawBody = $response->getBody()->getContents();
    }

    public function getRawBody()
    {
        return $this->rawBody;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getBodyValue(string $key)
    {
        return ArrayHelper::getValue($this->body, $key);
    }

    public function assertStatusCode(int $actualStatus, ResponseInterface $response = null)
    {
        $response = $response ?? $this->response;
        $statusCode = $response->getStatusCode();
        $this->assertEquals($actualStatus, $statusCode);
        return $this;
    }
}
