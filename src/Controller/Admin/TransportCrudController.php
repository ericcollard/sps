<?php

namespace App\Controller\Admin;

use App\Entity\Transport;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transport::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Transport')
            ->setEntityLabelInPlural('Transports');
    }

    public function configureFields(string $pageName): iterable
    {

        yield AssociationField::new('event','Sortie');
        $choices= ['Aller', 'Retour'];
        yield ChoiceField::new('direction','Direction')
            ->setChoices(array_combine($choices, $choices));


    }
}
