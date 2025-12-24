<?php

namespace App\Service\NLP\PreProcessing\Trait;

trait NlpPreProcessingServicePrivateFunctionProviderTrait
{
    private function toSmall(): void
    {
        $this->setText(strtolower($this->text));
    }
}
