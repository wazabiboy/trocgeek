<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Comments;
use App\Entity\Departements;
use App\Entity\Images;
use App\Entity\Regions;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/myadmin", name="myadmin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tutos Symfony5 1');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Region', 'fas fa-list', Regions::class);
        yield MenuItem::linkToCrud('categories', 'fas fa-list', Categories::class);
        yield MenuItem::linkToCrud('Images', 'fas fa-list', Images::class);
        yield MenuItem::linkToCrud('Annonces', 'fas fa-list', Annonces::class);
        yield MenuItem::linkToCrud('Departements', 'fas fa-list', Departements::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', Users::class);
        yield MenuItem::linkToCrud('Comment', 'fas fa-list', Comments::class);

        yield MenuItem::linkToUrl('Retour Au site', 'fas fa-arrow-circle-left', '/');

    }
}
