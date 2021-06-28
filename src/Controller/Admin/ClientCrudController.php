<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un client')
            ->setEntityLabelInPlural('Les Cients')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('name', 'Prénom');
        yield TextField::new('surname', 'Nom');
        yield TextField::new('adress', 'Adresse');
        yield TextField::new('zip_code', 'CP')
            ->hideOnIndex();
        yield TextField::new('city', 'Ville');
        yield TextField::new('state', 'Dépt')
            ->hideOnIndex();
        yield TextField::new('phone', 'Téléphone')
            ->hideOnIndex();
        yield EmailField::new('Email')
            ->hideOnIndex();
    }
}
