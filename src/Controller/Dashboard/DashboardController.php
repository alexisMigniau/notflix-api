<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Serie;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use App\Repository\SerieRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private UserRepository $userRepository,
        private MovieRepository $movieRepository,
        private SerieRepository $serieRepository,
        private CategoryRepository $categoryRepository,
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $user_url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        $movie_url = $this->adminUrlGenerator
            ->setController(MovieCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        $serie_url = $this->adminUrlGenerator
            ->setController(SerieCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        $category_url = $this->adminUrlGenerator
            ->setController(CategoryCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        return $this->render('dashboard/home.html.twig', [
            'user_count' => $this->userRepository->count([]),
            'movie_count' => $this->movieRepository->count([]),
            'serie_count' => $this->serieRepository->count([]),
            'category_count' => $this->categoryRepository->count([]),
            'user_link' => $user_url,
            'movie_link' => $movie_url,
            'serie_link' => $serie_url,
            'category_link' => $category_url
        ]);
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
