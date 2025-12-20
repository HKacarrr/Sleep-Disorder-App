<?php

namespace App\Controller;

use App\Service\Agent\SleepDisorder\SleepDisorderAgentService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MainController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return array_merge([
            SleepDisorderAgentService::class
        ], parent::getSubscribedServices());
    }

    #[Route('', name: 'app_main', methods: ['GET'])]
    public function main(): Response
    {
        return $this->render('main_page.html.twig');
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    #[Route('/sleep-analyze', name: 'sleep_analyze', methods: ['POST'])]
    public function sleepAnalyze(Request $request): JsonResponse
    {
        ini_set("max_execution_time", 1200);
        $data = $request->request->all();

        $response = $this->container->get(SleepDisorderAgentService::class)
            ->setData($data)
            ->analyze();

        return new JsonResponse(["message" => "Success", "response" => @$response["response"]], Response::HTTP_OK);
    }
}
