<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FamilyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Family::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Famille')
            ->setEntityLabelInPlural('Familles');
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield Field::new('name','Nom');
        yield Field::new('adress1','Adresse Ligne 1');
        yield Field::new('adress2','Adresse Ligne 2');
        yield Field::new('city','Ville');
        yield Field::new('codepos','Code postal');

    }

}
