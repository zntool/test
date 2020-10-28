<?php

namespace ZnTool\Test\Asserts;

use ZnCore\Base\Enums\Http\HttpHeaderEnum;
use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnLib\Rest\Helpers\RestResponseHelper;
use ZnTool\Test\Helpers\RestHelper;
use Psr\Http\Message\ResponseInterface;

class RpcAssert extends RestApiAssert
{

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

    public function assertUnprocessableEntity(array $fieldNames = [])
    {
        $this->assertIsError();
        $this->assertErrorMessage('Parameter validation error');
        $this->assertErrorCode(HttpStatusCodeEnum::UNPROCESSABLE_ENTITY);
        if ($fieldNames) {
            foreach ($this->getError()['violations'] as $item) {
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
