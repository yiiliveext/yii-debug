<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Debug;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Yii\Debug\Proxy\ContainerProxy;
use Yiisoft\Yii\Debug\Proxy\ContainerProxyConfig;

final class ProxyServiceProvider extends ServiceProvider
{
    /**
     * @psalm-suppress InaccessibleMethod
     */
    public function register(Container $container): void
    {
        $container->set(
            ContainerInterface::class,
            static function (ContainerInterface $container) {
                return new ContainerProxy($container, $container->get(ContainerProxyConfig::class));
            }
        );
    }
}
