<?php

namespace App\Controller\Admin;

use App\Entity\Operator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OperatorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Operator::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Un opérateur')
            ->setEntityLabelInPlural('Les opérateurs')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('name', 'Nom');
        yield TextField::new('adress', 'Adresse');
        yield TextField::new('zip_code', 'CP');
        yield TextField::new('city', 'Ville');
        yield TextField::new('siret', 'SIRET');
    }
}
