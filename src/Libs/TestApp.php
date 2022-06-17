<?php

namespace ZnTool\Test\Libs;

use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnSandbox\Sandbox\App\Base\BaseApp;

//use ZnSandbox\Sandbox\App\Subscribers\WebDetectTestEnvSubscriber;

class TestApp extends BaseApp
{

    protected $bundles = [];

    public function setBundles(array $bundles)
    {
        $this->bundles = $bundles;
    }

    protected function bundles(): array
    {
        $bundles = $this->bundles;
//        $bundles[] = new \App\Web\Bundle(['all']);

        $bundles[] = new \ZnCore\Base\Bundle(['all']);
        $bundles[] = new \ZnCore\Base\Libs\I18Next\Bundle(['all']);
        $bundles[] = new \ZnSandbox\Sandbox\App\Bundle(['all']);
        $bundles[] = \ZnDatabase\Base\Bundle::class;
        $bundles[] = \ZnDatabase\Fixture\Bundle::class;
//        $bundles[] = new \ZnSandbox\Sandbox\Symfony\NewBundle(['all']);

        return $bundles;
    }

    public function appName(): string
    {
        return 'test';
    }

    public function subscribes(): array
    {
        return [
//            WebDetectTestEnvSubscriber::class,
        ];
    }

    public function import(): array
    {
        return ['i18next', 'container'/*, 'symfonyWeb'*/];
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
//        $containerConfigurator->singleton(HttpKernelInterface::class, HttpKernel::class);
//        $containerConfigurator->bind(ErrorRendererInterface::class, HtmlErrorRenderer::class);
//        $containerConfigurator->singleton(View::class, View::class);
    }
}
