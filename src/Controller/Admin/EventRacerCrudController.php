<?php

namespace App\Controller\Admin;

use App\Entity\EventRacer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventRacerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventRacer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Lien Sortie - coureur')
            ->setEntityLabelInPlural('Liens Sortie - coureur');
    }

    public function configureFields(string $pageName): iterable
    {

        yield AssociationField::new('event','Sortie');
        yield AssociationField::new('racer','Coureur');
        yield Field::new('validated',"Imputation validée");

    }
}
