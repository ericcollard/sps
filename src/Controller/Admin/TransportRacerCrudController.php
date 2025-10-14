<?php

namespace App\Controller\Admin;

use App\Entity\TransportRacer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransportRacerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TransportRacer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Lien Transport - coureur')
            ->setEntityLabelInPlural('Liens Transport - coureur');
    }

    public function configureFields(string $pageName): iterable
    {

        yield AssociationField::new('transport','Transport');
        yield AssociationField::new('racer','Coureur');
        yield Field::new('racerPlace',"Réservation coureur");
        yield Field::new('nonracerPlaceCount',"Place(s) demandée pour un non coureur");
        yield Field::new('availablePlaceCount',"Place(s) proposées");
    }
}
