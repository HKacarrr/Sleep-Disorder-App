<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('', name: 'app_main', methods: ['GET'])]
    public function main(): Response
    {
        return $this->render('main_page.html.twig');
    }

    #[Route('/sleep-analyze', name: 'sleep_analyze', methods: ['POST'])]
    public function sleepAnalyze(Request $request)
    {
        sleep(10);
        dd($request->request->all());
    }
}
