<?php

namespace App\Controller\Admin;

use App\Entity\SkidayRacer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkidayRacerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SkidayRacer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Lien jour de ski - coureur')
            ->setEntityLabelInPlural('Liens jour de ski - coureur');
    }

    public function configureFields(string $pageName): iterable
    {

        yield AssociationField::new('skiday','Jour de ski');
        yield AssociationField::new('racer','Coureur');
        yield Field::new('trainingRacer',"Entrainement ?");
        yield Field::new('skipassRacer',"Besoin forfait ?");
        yield Field::new('lunchRacer',"Repas midi ?");
        yield Field::new('skipassNonracerCount',"Besoin forfait hors coureur");

    }
}
