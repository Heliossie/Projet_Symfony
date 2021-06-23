<?php

namespace App\Controller\Admin;

use App\Entity\Parking;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ParkingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Parking::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
