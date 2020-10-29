<?php

namespace ZnTool\Test\Asserts;

use App\Bus\Domain\Enums\RpcErrorCodeEnum;
use ZnCore\Base\Enums\Http\HttpHeaderEnum;
use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnLib\Rest\Helpers\RestResponseHelper;
use ZnTool\Test\Helpers\RestHelper;
use Psr\Http\Message\ResponseInterface;

class RpcAssert extends RestApiAssert
{

    public function __construct(ResponseInterface $response = null)
    {
        parent::__construct($response);
        $this->assertEqualsBodyValue('2.0', 'jsonrpc');
        $this->assertArrayHasKey('id', $this->getBody());
    }

    public function getResult()
    {
        return ArrayHelper::getValue($this->body, 'result');
    }

    public function getError()
    {
        return ArrayHelper::getValue($this->body, 'error');
    }

    public function assertErrorCode(int $code) {
        $this->assertEquals($code, $this->getError()['code']);
        return $this;
    }

    public function assertIsError() {
//        $this->assertEmpty($this->getBody());
        $this->assertNotEmpty($this->getError());
        return $this;
    }

    public function assertErrorMessage(string $message) {
        $this->assertEquals($message, $this->getError()['message']);
        return $this;
    }

    public function assertNotFound(string $message) {
        $this->assertIsError();
        $this->assertErrorCode(HttpStatusCodeEnum::NOT_FOUND);
        $this->assertErrorMessage($message);
        return $this;
    }

    public function assertEqualsBodyValue($expected, string $key)
    {
        $value = $this->getBodyValue($key);
        $this->assertEquals($expected, $value);
    }

    public function assertUnprocessableEntity(array $fieldNames = [])
    {
        $this->assertIsError();
        $this->assertErrorMessage('Parameter validation error');
        $this->assertErrorCode(RpcErrorCodeEnum::INVALID_PARAMS);
        if ($fieldNames) {
            foreach ($this->getError()['data'] as $item) {
                if (empty($item['field']) || empty($item['message'])) {
                    $this->expectExceptionMessage('Invalid errors array!');
                }
                $expectedBody[] = $item['field'];
            }
            $this->assertEquals($fieldNames, $expectedBody);
        }
        return $this;
    }

    public function assertSuccessResponse(array $result = [], int $id = null)
    {
        $this
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertBody([
                'jsonrpc' => '2.0',
                'result' => $result,
                'id' => $id,
            ]);
        return $this;
    }

    public function assertErrorResponse(array $error, int $id = null)
    {
        $this
            ->assertIsError()
            ->assertStatusCode(HttpStatusCodeEnum::OK)
            ->assertBody([
                'jsonrpc' => '2.0',
                'error' => $error,
                'id' => $id,
            ]);
        return $this;
    }
}
