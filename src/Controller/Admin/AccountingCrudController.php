<?php

namespace App\Controller\Admin;

use App\Entity\Accounting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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

        yield AssociationField::new('family','Famille');
        yield AssociationField::new('racer','Coureur');
        yield Field::new('ImputationDate',"Date");
        yield Field::new('value',"Valeur (négatif pour prélèvement)");
        yield Field::new('reason',"Motif");

    }
}
