<?php

namespace ZnTool\Test\Facades;

use Illuminate\Container\Container;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\App\Interfaces\AppInterface;
use ZnCore\Base\Libs\App\Libs\ZnCore;
use ZnTool\Test\Libs\TestApp;

class BoostrapTestFacade
{

    public static function init(array $bundles): AppInterface
    {
        $container = ContainerHelper::getContainer() ?: new Container();
        $znCore = new ZnCore($container);
        $znCore->init();

        /** @var ContainerConfiguratorInterface $containerConfigurator */
        $containerConfigurator = $container->get(ContainerConfiguratorInterface::class);
        $containerConfigurator->singleton(AppInterface::class, TestApp::class);

        /** @var AppInterface $appFactory */
        $appFactory = $container->get(AppInterface::class);
        return $appFactory;

    }
}
