<?php

namespace App\Service\Agent\SleepDisorder;

use App\Service\Agent\AbstractAgentService;
use App\Service\Agent\SleepDisorder\Trait\PrivateFunctionProviderTrait;
use App\Service\Agent\SleepDisorder\Trait\SleepDisorderAgentServiceGetterSetterTrait;
use App\Service\Agent\TextEditor\TextEditorAgentService;
use App\Service\Dataset\SleepHealth\SleepHealthDatasetService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\Service\ServiceMethodsSubscriberTrait;

class SleepDisorderAgentService extends AbstractAgentService
{
    public static function getSubscribedServices(): array
    {
        return array_merge([
            SleepHealthDatasetService::class,
            TextEditorAgentService::class
        ], parent::getSubscribedServices());
    }

    /** Traits */
    use SleepDisorderAgentServiceGetterSetterTrait, ServiceMethodsSubscriberTrait, PrivateFunctionProviderTrait;
    /** */

    /** Private Attributes */
    private array $data;
    private string $gender;
    private int $age;
    private string $job;
    private float $sleepDuration;
    private int $nightAwakenings;
    private int $sleepQuality;
    private string $lifeDescription;
    /** */

    /**
     * @throws NotFoundExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function analyze(): array
    {
        $this->setDataAttributes();
        $editedLifeDescription = $this->getTextEditorAgentService()->editText($this->lifeDescription);
        $this->lifeDescription = $editedLifeDescription;

        $response = $this->getHttpClient()->request('POST', 'http://localhost:11434/api/generate', [
            'json' => [
                'model' => 'qwen2.5:7b',
                'prompt' => $this->getPrompt(),
                'stream' => false,
                'options' => [
                    'temperature' => 0.1
                ]
            ],
            'timeout' => 120
        ]);

        return $response->toArray();
    }
}
