<?php

namespace App\Controller;

use App\Entity\Family;
use App\Repository\AccountingRepository;
use App\Repository\ContactRepository;
use App\Repository\RacerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FamilyController extends AbstractController
{
    #[Route('/family', name: 'app_family')]
    public function index(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $families = $em->getRepository(Family::class)->findBy([], ['name' => 'ASC']);

        return $this->render('family/index.html.twig', [
            'controller_name' => 'FamilyController',
                'families' => $families  ]);
    }

    #[Route('/family/{id}', name: 'family')]
    public function show(Family $family,
                         RacerRepository $racerRepository,
                         AccountingRepository $accountingRepository,
                         ContactRepository $contactRepository,
                         $tab=1): Response
    {
        $racers = $racerRepository->findBy(['family' => $family], ['name' => 'ASC']);
        $accountings = $accountingRepository->findByFamily($family->getId());
        $contacts  = $contactRepository->findBy(['family' => $family], ['type' => 'ASC']);
        $accountingPosition = $accountingRepository->getAccountingPositionForFamily($family->getId());

        return $this->render('family/show.html.twig', array(
            'family' => $family,
            'contacts' => $contacts,
            'racers' => $racers,
            'accountings' => $accountings,
            'accountingPosition' => $accountingPosition,
            'tab' => $tab
        ));

        //'accountingPositions' => $accountingPositions,
    }

}
