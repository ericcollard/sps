<?php

namespace App\Controller\Admin;

use App\Entity\Accomodation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccomodationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accomodation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Hébergement')
            ->setEntityLabelInPlural('Hébergements');
    }

    public function configureFields(string $pageName): iterable
    {
        yield Field::new('dayDate',"Date");
        yield AssociationField::new('event','Sortie');
        yield Field::new('location',"Lieu d'hébergement");
        yield Field::new('price',"Tarif de la nuité");

    }

}
