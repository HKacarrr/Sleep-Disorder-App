<?php

namespace App\Service\NLP\PreProcessing;

use App\Service\NLP\PreProcessing\Trait\NlpPreProcessingGetterSetterProviderTrait;
use App\Service\NLP\PreProcessing\Trait\NlpPreProcessingServicePrivateFunctionProviderTrait;
use Symfony\Contracts\Service\ServiceMethodsSubscriberTrait;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class NlpPreProcessingService implements ServiceSubscriberInterface
{
    /** Traits */
    use NlpPreProcessingServicePrivateFunctionProviderTrait, NlpPreProcessingGetterSetterProviderTrait, ServiceMethodsSubscriberTrait;
    /** */

    /** Service Subscriber */
    public static function getSubscribedServices(): array
    {
        return [];
    }
    /** */

    /** Attributes */
    private string $text;
    /** */

    public function preProcessing(): string
    {
        $this->toSmall();

        return $this->text;
    }
}
