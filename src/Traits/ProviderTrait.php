<?php

namespace ZnTool\Test\Traits;

use ZnLib\Rpc\Domain\Libs\RpcProvider;

trait ProviderTrait
{

    /*private $rpcProvider;
    
    private function initRpcProvider(string $baseUrl) {
        $this->rpcProvider = new RpcProvider();
        $this->rpcProvider->setBaseUrl($baseUrl);
        $this->rpcProvider->getRpcClient()->setHeaders([
            'env-name' => 'test',
        ]);
//        $this->rpcProvider->setDefaultRpcMethod($this->defaultRpcMethod());
        $this->rpcProvider->setDefaultRpcMethodVersion(1);
    }*/

    private function createRpcProvider(string $baseUrl): RpcProvider {
        $rpcProvider = new RpcProvider();
        $rpcProvider->setBaseUrl($baseUrl);
        $rpcProvider->getRpcClient()->setHeaders([
            'env-name' => 'test',
        ]);
//        $rpcProvider->setDefaultRpcMethod($this->defaultRpcMethod());
        $rpcProvider->setDefaultRpcMethodVersion(1);
        return $rpcProvider;
    }
    
    public function getRpcProvider(string $baseUrl): RpcProvider
    {
        return $this->createRpcProvider($baseUrl);
        /*if(empty($this->rpcProvider)) {
            $this->initRpcProvider($_ENV['API_URL']);
        }
        return $this->rpcProvider;*/
    }
}
