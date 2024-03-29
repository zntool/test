<?php

namespace ZnTool\Test\Traits;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnLib\Rpc\Domain\Libs\RpcFixtureProvider;

trait FixtureTrait
{

//    use BaseUrlTrait;
    use ProviderTrait;
    
    private $fixtures = [];
    private $fixtureProvider;

    protected function fixtures(): array
    {
        return [];
    }
    
    protected function addFixtures(array $fixtures)
    {
        $this->fixtures = ArrayHelper::merge($this->fixtures, $fixtures);
    }

    protected function importFixture() {
        $this->addFixtures($this->fixtures());
        if ($this->fixtures) {
            $this->getFixtureProvider($_ENV['API_URL'])->import($this->fixtures);
        }
    }

    protected function setUp(): void
    {
        $this->setBaseUrl($_ENV['API_URL']);
        $this->initFixtureProvider($_ENV['API_URL']);
        $this->importFixture();
        parent::setUp();
    }

    public function initFixtureProvider(string $baseUrl): void
    {
        if(empty($this->fixtureProvider)) {
            $this->fixtureProvider = new RpcFixtureProvider($this->getRpcProvider($baseUrl));
        }
    }
    
    public function getFixtureProvider(string $baseUrl = null): RpcFixtureProvider
    {
        /*if(empty($this->fixtureProvider)) {
            $this->fixtureProvider = new RpcFixtureProvider($this->getRpcProvider($baseUrl));
        }*/
        return $this->fixtureProvider;
    }
}