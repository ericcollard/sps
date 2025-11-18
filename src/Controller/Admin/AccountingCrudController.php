<?php

namespace App\Controller\Admin;

use App\Entity\Accounting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccountingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accounting::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Imputation')
            ->setEntityLabelInPlural('Imputations');
    }

    public function configureFields(string $pageName): iterable
    {

        yield AssociationField::new('family','Famille')
            ->setHelp('Choisir une famille pour un débit ou crédit se référant à toute la famille (sinon coureur)');
        yield AssociationField::new('racer','Coureur')
            ->setHelp('Choisir un licensié pour un débit ou crédit se référant à un individu (sinon famille)');
        yield AssociationField::new('event','Sortie')
            ->setHelp('Choisir une sortie uniquement si le débit est une imputation sortie');
        yield Field::new('ImputationDate',"Date");
        yield Field::new('value',"Valeur (€)")
        ->setHelp('négatif pour prélèvement, positif pour un crédit');
        yield Field::new('reason',"Motif");
        yield Field::new('updated_by',"Modifié par ...")->hideOnForm();
        yield DateTimeField::new('updated_at',"Modifié le ...")->hideOnForm();
    }
}
