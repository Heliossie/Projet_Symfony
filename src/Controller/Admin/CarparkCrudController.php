<?php

namespace App\Controller\Admin;

use App\Entity\Carpark;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarparkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carpark::class;
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
