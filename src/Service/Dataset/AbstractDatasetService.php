<?php

namespace App\Service\Dataset;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Service\ServiceMethodsSubscriberTrait;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

abstract class AbstractDatasetService implements ServiceSubscriberInterface
{
    use ServiceMethodsSubscriberTrait;

    public static function getSubscribedServices(): array
    {
        return [
            KernelInterface::class
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getKernelInterface()
    {
        return $this->container->get(KernelInterface::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getProjectDir()
    {
        return $this->getKernelInterface()->getProjectDir();
    }
}
