<?php

namespace App\Controller\Admin;

use App\Entity\Skiday;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkidayCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skiday::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('event','Période')->setColumns(6);
        yield DateField::new('dayDate','Date du jour de ski')->setColumns(6);
        yield Field::new('location','Station');
        $choices= ['Entrainement', 'Course'];
        yield ChoiceField::new('dayType','Type de journée')
            ->setChoices(array_combine($choices, $choices));

        yield TextField::new('memo','Commentaire')->hideOnIndex();
        yield Field::new('skipassYouthLimit','Age max forfait jeune (compris)')->setColumns(6)->hideOnIndex();
        yield Field::new('skipassPrice','Tarif forfait journée (hors coureur)')->setColumns(6);
        yield Field::new('lunchPrice','Tarif repas')->setColumns(6);
    }

}
