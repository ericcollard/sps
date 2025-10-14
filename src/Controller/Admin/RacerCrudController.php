<?php

namespace App\Controller\Admin;

use App\Entity\Racer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RacerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Racer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Coureur')
            ->setEntityLabelInPlural('Coureurs');
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addFieldset('Etat civil');

        yield Field::new('name','Prénom')->setColumns(6);
        yield AssociationField::new('family','Famille')->setColumns(6);

        $choices= ['Garçon', 'Fille'];
        yield ChoiceField::new('sex','Sexe')
            ->setChoices(array_combine($choices, $choices))->setColumns(6);

        yield DateField::new('birthDate','Date de naissance')->renderAsNativeWidget()->setColumns(6);;

        yield Field::new('size','Taille (cm)')->hideOnIndex()->setColumns(6);
        yield Field::new('weight','Poids (kg)')->hideOnIndex()->setColumns(6);


        yield FormField::addFieldset('License FFS');
        $choices= ['Non définie',
            'Compétition Junior',
            'Compétition Adulte',
            'Dirigeant Primo',
            'Dirigeant medium',
            'Dirigeant optimum',
            'Carte neige Junior primo',
            'Carte neige Junior medium',
            'Carte neige Adulte primo',
            'Carte neige Adulte medium',
            'Carte neige famille',
            'ESF' => 'ESF'];
        yield ChoiceField::new('licenseType','Type license')
            ->setChoices(array_combine($choices, $choices))->hideOnIndex()->setColumns(6);
        yield Field::new('licenseNumber','Licence N°')->setColumns(6);
        yield Field::new('licenseActivated','License active ?')->setColumns(3);
        yield Field::new('medicalActivated', 'Certificat médical ?')->hideOnIndex()->setColumns(3);
        yield Field::new('medical','spécificités médicales')->hideOnIndex()->setColumns(6);


        yield FormField::addFieldset('Classification');
        yield Field::new('isRacer','Coureur ?')->setColumns(4);
        yield Field::new('isSkiCoach','Entraineur ?')->hideOnIndex()->setColumns(4);
        yield Field::new('sntf','Carte SNTF ?')->hideOnIndex()->setColumns(4);

        yield Field::new('isSkiInstructor','Moniteur ?')->hideOnIndex()->setColumns(4);
        yield Field::new('isSkiInstructorLocation', 'Station du moniteur')->hideOnIndex()->setColumns(8);

        yield Field::new('clubActivated', 'Adhésion active ?')->setColumns(6);
        yield Field::new('applyActivated','Charte signée ?')->hideOnIndex()->setColumns(6);





    }

}
