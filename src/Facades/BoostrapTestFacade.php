<?php

namespace ZnTool\Test\Facades;

use ZnCore\Base\Container\Libs\Container;
use ZnCore\Base\Container\Helpers\ContainerHelper;
use ZnCore\Base\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\App\Interfaces\AppInterface;
use ZnCore\Base\App\Libs\ZnCore;
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
