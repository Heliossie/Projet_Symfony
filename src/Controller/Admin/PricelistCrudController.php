<?php

namespace App\Controller\Admin;

use App\Entity\Pricelist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PricelistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pricelist::class;
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
