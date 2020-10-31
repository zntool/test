<?php

namespace ZnTool\Test\Base;

use App\Bus\Domain\Entities\RpcRequestEntity;
use App\Bus\Domain\Entities\RpcResponseEntity;
use App\Bus\Domain\Entities\RpcResponseErrorEntity;
use App\Bus\Domain\Entities\RpcResponseResultEntity;
use App\Bus\Domain\Enums\RpcVersionEnum;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rest\Contract\Authorization\AuthorizationInterface;
use ZnLib\Rest\Contract\Authorization\BearerAuthorization;
use ZnLib\Rest\Contract\Client\RestClient;
use ZnLib\Rest\Contract\Client\RpcClient;
use ZnLib\Rest\Helpers\RestResponseHelper;
use ZnTool\Test\Asserts\RestApiAssert;
use ZnTool\Test\Asserts\RpcAssert;
use ZnTool\Test\Base\BaseRestApiTest;

abstract class BaseRpcTest extends BaseTest
{

    private $restClient;
    
    protected function authBy(string $login, string $password)
    {
        $response = $this->sendRequest('auth.getToken', [
            'login' => $login,
            'password' => $password,
        ]);

        return $response->getResult()['token'];
    }

    protected function getRpcAssert(RpcResponseEntity $response = null): RpcAssert
    {
        $assert = new RpcAssert($response);
        return $assert;
    }

    protected function sendRequestByEntity(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        return $this->getRpcClient()->sendRequestByEntity($requestEntity);
    }

    protected function sendRequest(string $method, array $params = [], array $meta = [], int $id = null): RpcResponseEntity
    {
        $request = new RpcRequestEntity();
        $request->setMethod($method);
        $request->setParams($params);
        $request->setMeta($meta);
        $request->setId($id);
        $response = $this->sendRequestByEntity($request);
        return $response;
    }

    protected function printContent(ResponseInterface $response = null, string $filter = null)
    {
        $response->getBody()->rewind();
        $content = $response->getBody()->getContents();
        if ($filter) {
            $content = $filter($content);
        }
        dd($content);
    }

    protected function getAuthorizationContract(Client $guzzleClient): AuthorizationInterface
    {
        return new BearerAuthorization($guzzleClient);
    }

    protected function getRpcClient(): RpcClient
    {
        $guzzleClient = $this->getGuzzleClient();
        $authAgent = $this->getAuthorizationContract($guzzleClient);
        return new RpcClient($guzzleClient, $authAgent);
    }

    protected function getGuzzleClient(): Client
    {
        $config = [
            'base_uri' => $this->getBaseUrl(),
        ];
        $client = new Client($config);
        return $client;
    }

    protected function getBaseUrl(): string
    {
        $baseUrl = $_ENV['API_URL'];
        $baseUrl = trim($baseUrl, '/');
        return $baseUrl;
    }
}
