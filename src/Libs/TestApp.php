<?php

namespace ZnTool\Test\Libs;

use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnSandbox\Sandbox\App\Subscribers\ErrorHandleSubscriber;
use ZnSandbox\Sandbox\App\Subscribers\FindRouteSubscriber;
use ZnSandbox\Sandbox\App\Subscribers\WebDetectTestEnvSubscriber;
use ZnSandbox\Sandbox\App\Subscribers\WebFirewallSubscriber;
use ZnLib\Web\View\View;
use ZnSandbox\Sandbox\App\Base\BaseApp;

class TestApp extends BaseApp
{

    protected $bundles = [];
    
    public function setBundles(array $bundles) {
        $this->bundles = $bundles;
    }
    
    protected function bundles(): array
    {
        $bundles = $this->bundles;
//        $bundles[] = new \App\AppWeb\Bundle(['all']);
        
        $bundles[] = new \ZnCore\Base\Bundle(['all']);
        $bundles[] = new \ZnCore\Base\Libs\I18Next\Bundle(['all']);
        $bundles[] = new \ZnSandbox\Sandbox\App\Bundle(['all']);
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

    protected function configDispatcher(EventDispatcherInterface $dispatcher): void
    {
        /*$dispatcher->addSubscriber($this->container->get(FindRouteSubscriber::class));
        $dispatcher->addSubscriber($this->container->get(WebFirewallSubscriber::class));
        //$dispatcher->addSubscriber($this->container->get(UnauthorizedSubscriber::class));
        $dispatcher->addSubscriber($this->container->get(ErrorHandleSubscriber::class));*/
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
//        $containerConfigurator->singleton(HttpKernelInterface::class, HttpKernel::class);
//        $containerConfigurator->bind(ErrorRendererInterface::class, HtmlErrorRenderer::class);
//        $containerConfigurator->singleton(View::class, View::class);
    }
}
