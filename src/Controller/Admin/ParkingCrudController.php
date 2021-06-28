<?php

namespace App\Controller\Admin;

use App\Entity\Parking;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class ParkingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Parking::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un parking')
            ->setEntityLabelInPlural('Les Parkings')
            ->setDefaultSort(['id' => 'ASC']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('id_ext', 'ID externe')
                ->hideOnIndex();
        yield TextField::new('name', 'Nom');
        yield TextField::new('adress', 'Adresse');
        yield TextField::new('insee')
                ->hideOnIndex();
        yield NumberField::new('xlong', 'Long')
                ->hideOnIndex();
        yield NumberField::new('ylat', 'Lat')
                ->hideOnIndex();
        yield NumberField::new('nb_places', 'Nb. places');
    }
}
