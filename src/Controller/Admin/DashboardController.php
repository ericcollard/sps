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

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();
        return $this->render('admin/main.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
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
