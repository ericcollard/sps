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
use Doctrine\ORM\EntityManagerInterface;
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
    private ?EntityManagerInterface $em = null;

    public function __construct(
        EntityManagerInterface $em,
    ) {
        $this->em = $em;
    }

    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $this->em->getRepository(User::class)->findBy([], ['email' => 'ASC']);
        $accounting = $this->em->getRepository(Accounting::class)->getAccountingPosition();
        if (!$accounting) $accounting = 0;
        $cntRacers = $this->em->getRepository(Racer::class)->getActiveCnt();
        if (!$cntRacers) $cntRacers = 0;

        return $this->render('admin/main.html.twig',[
            'users' => $users,
            'accounting' => $accounting,
            'cntRacers' => $cntRacers
        ]);
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
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Familles', 'fa fa-users', Family::class);
        yield MenuItem::linkToCrud('Contacts', 'fa fa-address-book', Contact::class);
        yield MenuItem::linkToCrud('Coureurs', 'fa fa-person-skiing', Racer::class);
        yield MenuItem::linkToCrud('Sortie', 'fa fa-calendar', Event::class);
        yield MenuItem::linkToCrud('Comptabilité', 'fa fa-euro-sign', Accounting::class);
        yield MenuItem::linkToCrud('Paramètres', 'fa fa-gears', Parameter::class);
        yield MenuItem::linkToCrud('Grille de tarifs', 'fa fa-money-check-dollar', Pricetemplate::class);
        yield MenuItem::linkToCrud('Hébergements', 'fa fa-bed', Accomodation::class);
        yield MenuItem::linkToCrud('Transport', 'fa fa-van-shuttle', Transport::class);
        yield MenuItem::linkToCrud('Journée ski', 'fa fa-person-skiing', Skiday::class);

        yield MenuItem::linkToCrud('Hébergement coureur', 'fa fa-lock', AccomodationRacer::class);
        yield MenuItem::linkToCrud('Sortie coureur', 'fa fa-lock', EventRacer::class);
        yield MenuItem::linkToCrud('Journée ski coureur', 'fa fa-lock', SkidayRacer::class);
        yield MenuItem::linkToCrud('Transport coureur', 'fa fa-lock', TransportRacer::class);

    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
