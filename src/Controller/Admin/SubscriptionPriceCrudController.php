<?php

namespace App\Controller\Admin;

use App\Entity\SubscriptionPrice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SubscriptionPriceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubscriptionPrice::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un abonnement')
            ->setEntityLabelInPlural('des abonnements')
            ->setDefaultSort(['id' => 'ASC']);
    }


    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('Date')
            ->setFormTypeOptions([
                'html5' => true,
                'years' => range(date('Y'), date('Y') + 2),
                'widget' => 'single_text',
            ]);
        yield NumberField::new('amount_sub', "Montant de l'abonnement");
    }
}
