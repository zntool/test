<?php

namespace ZnTool\Test\Libs;

use ZnCore\Base\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\App\Base\BaseApp;

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

        $bundles[] = new \ZnLib\Components\CommonTranslate\Bundle(['all']);
        $bundles[] = new \ZnLib\Components\SymfonyTranslation\Bundle(['all']);
        $bundles[] = new \ZnLib\Components\I18Next\Bundle(['all']);
        $bundles[] = new \ZnLib\Components\DefaultApp\Bundle(['all']);
        $bundles[] = \ZnDatabase\Base\Bundle::class;
        $bundles[] = \ZnDatabase\Fixture\Bundle::class;
//        $bundles[] = new \ZnSf\Web\Bundle(['all']);

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
