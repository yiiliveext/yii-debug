<?php

namespace Yiisoft\Yii\Debug\Tests\Collector;

use hiqdev\composer\config\Builder;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yiisoft\Di\Container;
use Yiisoft\Yii\Debug\Collector\CollectorInterface;
use Yiisoft\Yii\Debug\Target\MemTarget;
use Yiisoft\Yii\Debug\Target\TargetInterface;

abstract class AbstractCollectorTestCase extends TestCase
{
    protected ContainerInterface $container;

    /**
     * @dataProvider targetProvider()
     * @param \Yiisoft\Yii\Debug\Target\TargetInterface $target
     */
    public function testExport(TargetInterface $target): void
    {
        $collector = $this->getCollector($target);
        $collector->setTarget($target);
        $this->assertEmpty($target->getData());
        $this->somethingDoTestExport();
        $collector->export();
        var_dump($target->getData());
        $this->assertNotEmpty(...$target->getData());
    }

    public function targetProvider(): array
    {
        return [
            [new MemTarget()],
        ];
    }

    abstract protected function getCollector(TargetInterface $target): CollectorInterface;

    protected function setUp(): void
    {
        $config = require Builder::path('tests');

        $this->container = new Container($config);
    }

    protected function somethingDoTestExport(): void
    {
    }
}