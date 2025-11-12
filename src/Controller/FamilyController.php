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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
                         EntityManagerInterface $em,
                         $tab=1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $this->checkEditCredentials($family,$em);

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

    public function checkEditCredentials($family,EntityManagerInterface $em)
    {
        if ($this->isGranted('ROLE_ADMIN')) return true;
        if ($family)
        {
            $authUserfamily = $em->getRepository(Family::class)->findOneByLogin($this->getUser()->getEmail());
            if (!$authUserfamily)
                throw new AccessDeniedException('Pas de famille associée au login courant !');
            if ($authUserfamily->getId() != $family->getId())
                throw new AccessDeniedException('Opération interdite hors famille connectée !');
        }
        else
        {
            throw new AccessDeniedException('Opération interdite si pas de famille sélectionnée');
        }
    }

}
