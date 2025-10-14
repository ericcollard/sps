<?php

namespace App\Controller;

use App\Entity\Racer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RacerController extends AbstractController
{
    #[Route('/racer', name: 'app_racer')]
    public function index(): Response
    {
        return $this->render('racer/index.html.twig', [
            'controller_name' => 'RacerController',
        ]);
    }
}
