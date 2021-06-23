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

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Park It');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Les parkings', 'fas fa-list', Parking::class);
        yield MenuItem::linkToCrud('Les clients', 'fas fa-list', Client::class);
        yield MenuItem::linkToCrud('Les stationnements', 'fas fa-list', Carpark::class);
        yield MenuItem::linkToCrud('Les factures', 'fas fa-list', Invoice::class);
        yield MenuItem::linkToCrud('Les opérateurs', 'fas fa-list', Operator::class);
        yield MenuItem::linkToCrud('Les tarifs', 'fas fa-list', Pricelist::class);
    }
}
