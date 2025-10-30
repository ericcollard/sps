<?php

namespace App\Controller\Admin;

use App\Entity\Event;
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

}
