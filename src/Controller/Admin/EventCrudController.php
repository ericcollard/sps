<?php

namespace App\Controller\Admin;

use App\Entity\Accomodation;
use App\Entity\Event;
use App\Entity\Parameter;
use App\Entity\Skiday;
use App\Entity\SkidayRacer;
use App\Entity\Transport;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Sortie')
            ->setEntityLabelInPlural('Sorties');
    }


    public function configureFields(string $pageName): iterable
    {
        yield Field::new('title','Titre');
        yield DateField::new('startdate','Date de début');
        yield DateField::new('enddate','Date de fin');
        $choices= ['Sortie SCPA', 'Vacances scolaires'];
        yield ChoiceField::new('type','Type de période')
            ->setChoices(array_combine($choices, $choices));
        yield Field::new('DefaultAccomodationLocation',"Lieu d'hébergement");
        yield Field::new('DefaultSkidayLocation',"Station");
        yield TextField::new('memo','Commentaire')->hideOnIndex();

    }

    public function configureActions(Actions $actions): Actions
    {
        $viewImputation = Action::new('viewImputation', 'Imputation sortie')
            ->setIcon('fa fa-file-invoice')
            ->asPrimaryAction()
            ->linkToUrl(fn (Event $event) => '/planning/imputation/'.$event->getId())
        ;

        $viewSummary = Action::new('viewSummary', 'Fiche résumé sortie')
            ->setIcon('fa fa-file-invoice')
            ->asPrimaryAction()
            ->linkToUrl(fn (Event $event) => '/planning/summary?eventId='.$event->getId())
        ;

        return $actions
            ->add(Crud::PAGE_DETAIL, $viewImputation)
            ->add(Crud::PAGE_DETAIL, $viewSummary)
            ;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->getStartdate() > $entityInstance->getEnddate()) {
            throw new \LogicException('Attention : dates incohérentes. La date de début doit précéder la date de fin');
        }

        parent::persistEntity($entityManager, $entityInstance);
        // Tache post création

        if ($entityInstance->getType() == 'Sortie SCPA')
        {
            $start = $entityInstance->getStartdate();
            $end = $entityInstance->getEnddate();
            $current = clone $start;
            $interval = DateInterval::createFromDateString('1 day');
            $defaultAccomodationLocation = "";
            $defaultSkidayLocation = "";
            $defaultAccomodationPrice = $entityManager->getRepository(Parameter::class)->getNumericParameter('DefaultNonRacerAccomodationPrice');
            $defaultSkipassYouthLimit = $entityManager->getRepository(Parameter::class)->getNumericParameter('DefaultSkipassYouthLimit');
            $defaultNonRacerSkipassPrice = $entityManager->getRepository(Parameter::class)->getNumericParameter('DefaultNonRacerSkipassPrice');
            $defaultLunchCost = $entityManager->getRepository(Parameter::class)->getNumericParameter('DefaultLunchCost');


            if ($entityInstance->getDefaultAccomodationLocation()) $defaultAccomodationLocation = $entityInstance->getDefaultAccomodationLocation();
            if ($entityInstance->getDefaultSkidayLocation()) $defaultSkidayLocation = $entityInstance->getDefaultSkidayLocation();

            while ($current <= $end) {
                if ($current != $end)
                {
                    // Hébergement
                    $accomodation = (new Accomodation())
                        ->setEvent($entityInstance)
                        ->setDayDate($current)
                        ->setLocation($defaultAccomodationLocation)
                        ->setPrice($defaultAccomodationPrice);
                    $entityManager->persist($accomodation);
                    $entityManager->flush();
                }
                if ($current == $start)
                {
                    // Transport
                    $transport = (new Transport())
                        ->setEvent($entityInstance)
                        ->setDirection('Aller');
                    $entityManager->persist($transport);
                    $entityManager->flush();
                }
                if ($current == $end)
                {
                    // Transport
                    $transport = (new Transport())
                        ->setEvent($entityInstance)
                        ->setDirection('Retour');
                    $entityManager->persist($transport);
                    $entityManager->flush();
                }
                $skiday = (new Skiday())
                    ->setDayDate($current)
                    ->setLocation($defaultSkidayLocation)
                    ->setDayType('Entrainement')
                    ->setSkipassYouthLimit($defaultSkipassYouthLimit)
                    ->setSkipassPrice($defaultNonRacerSkipassPrice)
                    ->setLunchPrice($defaultLunchCost)
                    ->setEvent($entityInstance)
                ;
                $entityManager->persist($skiday);
                $entityManager->flush();
                $current->add($interval);
            }
        }

        $this->addFlash('success', 'Sortie crée avec les composantes transport et hébergement - paramètres par défaut à contrôler.');

    }

    public function deleteEntity(EntityManagerInterface $entityManager, $eventInstance): void
    {
        // TRANSPORT
        foreach ($eventInstance->getTransports() as $transport)
        {
            foreach ($transport->getTransportRacers() as $transportRacer)
            {
                $entityManager->remove($transportRacer);
            }
            $entityManager->remove($transport);
        }
        // ACCOMODATION
        foreach ($eventInstance->getAccomodations() as $accomodation)
        {
            foreach ($accomodation->getAccomodationRacers() as $accomodationRacer)
            {
                $entityManager->remove($accomodationRacer);
            }
            $entityManager->remove($accomodation);
        }
        // SKIDAYS
        foreach ($eventInstance->getSkidays() as $skiday)
        {
            foreach ($skiday->getSkidayRacers() as $skidayRacer)
            {
                $entityManager->remove($skidayRacer);
            }
            $entityManager->remove($skiday);
        }

        $entityManager->remove($eventInstance);
        $entityManager->flush();
    }

}
