<?php

namespace App\Service\Dataset\SleepHealth;

use App\Service\Dataset\AbstractDatasetService;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SleepHealthDatasetService extends AbstractDatasetService
{
    const string DATASET_PATH = "/public/datasets/Sleep_health_and_lifestyle_dataset.csv";

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function getDataset(): false|string
    {
        $csvPath = $this->getProjectDir() . self::DATASET_PATH;
        if (!file_exists($csvPath)) {
            throw new Exception('Dataset not found');
        }

        return file_get_contents($csvPath);
    }
}
