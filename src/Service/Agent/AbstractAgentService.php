<?php

namespace App\Service\Agent;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Service\ServiceMethodsSubscriberTrait;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

abstract class AbstractAgentService implements ServiceSubscriberInterface
{
    use ServiceMethodsSubscriberTrait;

    public static function getSubscribedServices(): array
    {
        return [
            HttpClientInterface::class
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getHttpClient()
    {
        return $this->container->get(HttpClientInterface::class);
    }
}
