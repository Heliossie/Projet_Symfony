<?php

namespace App\Controller\Admin;

use App\Entity\Pricelist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class PricelistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pricelist::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un tarif')
            ->setEntityLabelInPlural('Les Tarifs')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TimeField::new('duration', 'Durée');
        yield NumberField::new('price', 'Prix');
    }
}
