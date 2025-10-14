<?php

namespace App\Controller\Admin;

use App\Entity\AccomodationRacer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccomodationRacerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AccomodationRacer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Lien hébergement - coureur')
            ->setEntityLabelInPlural('Liens hébergement - coureur');
    }

    public function configureFields(string $pageName): iterable
    {

        yield AssociationField::new('accomodation','Hébergement');
        yield AssociationField::new('racer','Coureur');
        yield Field::new('racerPlace',"Réservation coureur");
        yield Field::new('nonracerPlaceCount',"Place(s) demandée pour un non coureur");

    }
}
