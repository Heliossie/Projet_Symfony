<?php

namespace App\Controller\Admin;

use App\Entity\Carpark;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CarparkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carpark::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un stationnement')
            ->setEntityLabelInPlural('Les Stationnements')
            ->setDefaultSort(['id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('client');
        yield AssociationField::new('invoice', 'Facture');
        yield AssociationField::new('parking');
        yield DateTimeField::new('arrival', 'Arrivée')
            ->setFormTypeOptions([
                'html5' => true,
                'years' => range(date('Y'), date('Y') + 2),
                'widget' => 'single_text',
            ]);
        yield DateTimeField::new('departure', 'Départ')
            ->setFormTypeOptions([
                'html5' => true,
                'years' => range(date('Y'), date('Y') + 2),
                'widget' => 'single_text',
            ]);
        yield NumberField::new('price', 'Prix');
    }
}
