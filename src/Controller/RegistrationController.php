<?php

namespace App\Controller;

use App\Entity\Parameter;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formClubCode = $form->get('clubCode')->getData();
            $securityCode = $entityManager->getRepository(Parameter::class)->findOneBy(['name' => 'RegisterSecurityCode']);
            if ($securityCode)
            {
                if ($securityCode->getStringValue() == $formClubCode)
                {
                    /** @var string $plainPassword */
                    $plainPassword = $form->get('plainPassword')->getData();

                    // encode the plain password
                    $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

                    $entityManager->persist($user);
                    $entityManager->flush();

                    // do anything else you need here, like send an email
                    $this->addFlash('success','Utilisateur créé avec succès');
                }
                else
                {
                    $this->addFlash('warning', 'Le code de sécurité fourni est erroné');
                    return $this->redirectToRoute('app_register');
                }
            }
            else
            {
                $this->addFlash('danger', "Paramétrage du SecurityCode manquant - contacter l'administrateur");
                return $this->redirectToRoute('app_register');
            }

            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
