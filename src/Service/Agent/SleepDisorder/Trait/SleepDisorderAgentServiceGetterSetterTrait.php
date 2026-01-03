<?php

namespace App\Service\Agent\SleepDisorder\Trait;

trait SleepDisorderAgentServiceGetterSetterTrait
{
    protected function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    private function setDataAttributes(): void
    {
        $data = $this->data;
        $this->gender = @$data["gender"];
        $this->age = @$data["age"];
        $this->job = @$data["job"];
        $this->sleepDuration = @$data["sleep_duration"];
        $this->nightAwakenings = @$data["night_awakenings"];
//        $this->sleepQuality = @$data["sleep_quality"];
        $this->lifeDescription = @$data["short_life_description"];
    }
}
