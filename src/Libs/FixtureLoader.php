<?php

namespace ZnTool\Test\Libs;

use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Domain\Libs\EntityManager;
use ZnDatabase\Eloquent\Domain\Capsule\Manager;
use ZnDatabase\Fixture\Domain\Repositories\DbRepository;
use ZnDatabase\Fixture\Domain\Repositories\FileRepository;
use ZnDatabase\Fixture\Domain\Services\FixtureService;
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
        $this->loadAllFixtures($fixtures);
        /*foreach ($fixtures as $fixture) {
            $this->loadFixture($fixture);
        }*/
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
            $container = ContainerHelper::getContainer();
            $dbRepository = $container->get(DbRepository::class);
            $fileRepository = $container->get(FileRepository::class);
            $fixtureService = new FixtureService($dbRepository, $fileRepository);
            $fixtureService->importAll($fixture);
        }
    }
    
    private function loadAllFixtures(array $fixtures) {
        $container = ContainerHelper::getContainer();
        $dbRepository = $container->get(DbRepository::class);
        $fileRepository = $container->get(FileRepository::class);
        $fixtureService = new FixtureService($dbRepository, $fileRepository);
        $fixtureService->importAll($fixtures);
    }
}
