<?php

namespace App\Controller\Admin;

use App\Entity\Operator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OperatorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Operator::class;
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
