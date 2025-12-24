<?php

namespace App\Service\NLP\PreProcessing\Trait;

trait NlpPreProcessingGetterSetterProviderTrait
{
    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    protected function getText(): string
    {
        return $this->text;
    }
}
