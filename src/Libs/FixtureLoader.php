<?php

namespace ZnTool\Test\Libs;

use ZnCore\Db\Db\Capsule\Manager;
use ZnCore\Db\Fixture\Repositories\DbRepository;
use ZnCore\Db\Fixture\Repositories\FileRepository;
use ZnCore\Db\Fixture\Services\FixtureService;
use ZnTool\Test\Libs\FixtureLoader\FixtureLoaderInterface;
use ZnTool\Test\Libs\FixtureLoader\YiiFixtureLoader;
use yii\test\Fixture;

class FixtureLoader
{

    protected $loaderInstances = [];
    protected $loaders = [
        YiiFixtureLoader::class => [
            Fixture::class,
        ],
    ];

    public function load(array $fixtures)
    {
        if (empty($fixtures)) {
            return;
        }
        foreach ($fixtures as $fixture) {
            $this->loadFixture($fixture);
        }
    }

    private function getFixtureLoaderClass($fixture): string
    {
        foreach ($this->loaders as $loaderClassName => $fixtureParents) {
            foreach ($fixtureParents as $fixtureParent) {
                $isSubClass = is_subclass_of($fixture, $fixtureParent);
                if ($isSubClass) {
                    return $loaderClassName;
                }
            }
        }
    }

    private function createLoaderInstance($fixture): FixtureLoaderInterface
    {
        $fixtureLoaderClassName = $this->getFixtureLoaderClass($fixture);
        if ( ! isset($this->loaderInstances[$fixtureLoaderClassName])) {
            $this->loaderInstances[$fixtureLoaderClassName] = new $fixtureLoaderClassName;
        }
        return $this->loaderInstances[$fixtureLoaderClassName];
    }

    private function loadFixture(string $fixture)
    {
        if(class_exists($fixture)) {
            $fixtureLoaderInstance = $this->createLoaderInstance($fixture);
            $fixtureLoaderInstance->loadFixtures([$fixture]);
        } elseif (file_exists($fixture)) {

        } else {
            $fixtureService = new FixtureService(new DbRepository(new Manager), new FileRepository());
            $fixtureService->importTable($fixture);
        }
    }
}
