<?php

namespace App\Controller\Admin;

use App\Entity\Accomodation;
use App\Entity\AccomodationRacer;
use App\Entity\Accounting;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\EventRacer;
use App\Entity\Family;
use App\Entity\Parameter;
use App\Entity\Pricetemplate;
use App\Entity\Racer;
use App\Entity\Skiday;
use App\Entity\SkidayRacer;
use App\Entity\Transport;
use App\Entity\TransportRacer;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/main.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration Sps');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Homepage', 'fas fa-home', $this->generateUrl('homepage'));
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Familles', 'fa fa-list', Family::class);
        yield MenuItem::linkToCrud('Contacts', 'fa fa-list', Contact::class);
        yield MenuItem::linkToCrud('Coureurs', 'fa fa-list', Racer::class);
        yield MenuItem::linkToCrud('Hébergements', 'fa fa-list', Accomodation::class);
        yield MenuItem::linkToCrud('Hébergement coureur', 'fa fa-list', AccomodationRacer::class);
        yield MenuItem::linkToCrud('Sortie', 'fa fa-list', Event::class);
        yield MenuItem::linkToCrud('Sortie coureur', 'fa fa-list', EventRacer::class);
        yield MenuItem::linkToCrud('Comptabilité', 'fa fa-list', Accounting::class);
        yield MenuItem::linkToCrud('Grille de tarifs', 'fa fa-list', Pricetemplate::class);
        yield MenuItem::linkToCrud('Journée ski', 'fa fa-list', Skiday::class);
        yield MenuItem::linkToCrud('Journée ski coureur', 'fa fa-list', SkidayRacer::class);
        yield MenuItem::linkToCrud('Transport', 'fa fa-list', Transport::class);
        yield MenuItem::linkToCrud('Transport coureur', 'fa fa-list', TransportRacer::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-list', User::class);
        yield MenuItem::linkToCrud('Paramètres', 'fa fa-list', Parameter::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
