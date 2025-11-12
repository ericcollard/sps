<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Parameter;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use function PHPUnit\Framework\throwException;

class DefaultController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/', name: 'homepage')]
    function index (): Response
    {
        return $this->render('homepage.html.twig');
    }

    #[Route('/help', name: 'help')]
    function help (EntityManagerInterface $entityManager): Response
    {
        $help = $entityManager->getRepository(Parameter::class)->findOneBy(['name' => 'Help']);
        if (!$help)
            throw new Exception("Paramètre Help non défini");

        return $this->render('help.html.twig',
            [
                'helpText'=>$help->getTextvalue(),
            ]);
    }

}
