<?php

namespace App\Service\Agent\TextEditor;

use App\Service\Agent\AbstractAgentService;
use App\Service\Agent\TextEditor\Trait\TextEditorAgentServicePrivateFunctionProviderTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TextEditorAgentService extends AbstractAgentService
{
    use TextEditorAgentServicePrivateFunctionProviderTrait;

    /**
     * @throws NotFoundExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function editText(string $message)
    {
        $response = $this->getHttpClient()->request('POST', 'http://localhost:11434/api/generate', [
            'json' => [
                'model' => 'llama3.1:8b',
                'prompt' => $this->getPrompt($message),
                'stream' => false,
                'options' => [
                    'temperature' => 0.1
                ]
            ],
            'timeout' => 120
        ]);

        $arrayResponse = $response->toArray();
        return @$arrayResponse["response"];
    }
}
