<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Serie;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/home.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Notflix');
    }

    public function configureMenuItems(): iterable
    {
        return [ 
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section(),
            MenuItem::linkToCrud('Movies', 'fa fa-film', Movie::class),
            MenuItem::section(),
            MenuItem::linkToCrud('Series', 'fa fa-film', Serie::class),
            MenuItem::section(),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::section(),
            MenuItem::linkToCrud('Categories', 'fa fa-tag', Category::class),
        ];
    }
}
