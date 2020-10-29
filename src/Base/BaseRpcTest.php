<?php

namespace ZnTool\Test\Base;

use App\Bus\Domain\Entities\RpcRequestEntity;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use ZnCore\Base\Enums\Http\HttpStatusCodeEnum;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rest\Contract\Authorization\AuthorizationInterface;
use ZnLib\Rest\Contract\Authorization\BearerAuthorization;
use ZnLib\Rest\Contract\Client\RestClient;
use ZnLib\Rest\Contract\Client\RpcClient;
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

        $assert = $this->getRpcAssert($response);
        $token = $assert->getBodyValue('result.token');
        return $token;
    }

    protected function getRpcAssert(ResponseInterface $response = null): RpcAssert
    {
        $assert = new RpcAssert($response);
        return $assert;
    }

    protected function sendRequestByEntity(RpcRequestEntity $requestEntity): ResponseInterface
    {
        $requestEntity->setJsonrpc('2.0');
        $data = EntityHelper::toArray($requestEntity);
        $response = $this->getRestClient()->sendPost('/json-rpc', [
            'data' => json_encode($data),
        ]);
        return $response;
    }

    protected function sendRequest(string $method, array $params, array $meta = [], int $id = null): ResponseInterface
    {
        $response = $this->getRestClient()->sendPost('/json-rpc', [
            'data' => json_encode([
                'jsonrpc' => '2.0',
                'method' => $method,
                'params' => $params,
                'meta' => $meta,
                'id' => $id,
            ]),
        ]);
        return $response;
    }

    protected function printContent(ResponseInterface $response = null, string $filter = null)
    {
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

    protected function getRestClient(): RpcClient
    {
        $guzzleClient = $this->getGuzzleClient();
        $authAgent = $this->getAuthorizationContract($guzzleClient);
        return new RpcClient($guzzleClient, $authAgent);
    }

    protected function getGuzzleClient(): Client
    {
        $config = [
            'base_uri' => $this->getBaseUrl() . '/',
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
