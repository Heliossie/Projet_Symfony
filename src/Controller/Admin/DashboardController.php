<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Carpark;
use App\Entity\Client;
use App\Entity\Invoice;
use App\Entity\Operator;
use App\Entity\Parking;
use App\Entity\Pricelist;
use App\Entity\SubscriptionPrice;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Park It');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Site public', 'fa fa-home', '/');
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-tachometer-alt');
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Les parkings', 'fas fa-parking', Parking::class);
        yield MenuItem::linkToCrud('Les stationnements', 'fas fa-car', Carpark::class);
        yield MenuItem::linkToCrud('Les clients', 'fas fa-users', Client::class);
        yield MenuItem::linkToCrud('Les opérateurs', 'fas fa-user-tie', Operator::class);
        yield MenuItem::linkToCrud('Les factures', 'fas fa-file-invoice', Invoice::class);
        yield MenuItem::linkToCrud('Les tarifs', 'fas fa-euro-sign', Pricelist::class);
        yield MenuItem::linkToCrud('Les abonnements', 'fas fa-list-alt', SubscriptionPrice::class);
    }
}
