<?php

namespace App\Controller;

use App\Entity\Accomodation;
use App\Entity\AccomodationRacer;
use App\Entity\Accounting;
use App\Entity\Event;
use App\Entity\EventRacer;
use App\Entity\Family;
use App\Entity\Parameter;
use App\Entity\Pricetemplate;
use App\Entity\Racer;
use App\Entity\Skiday;
use App\Entity\SkidayOptions;
use App\Entity\SkidayRacer;
use App\Entity\Transport;
use App\Entity\TransportRacer;
use App\Form\SkidayOptionsType;
use App\Repository\TransportRacerRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Config\TwigExtra\StringConfig;
use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\isNumeric;
use function PHPUnit\Framework\throwException;

final class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(Request $request,EntityManagerInterface $em,LoggerInterface $logger): Response
    {
        // Paramètres : choix du mois à afficher
        $month = (int)$request->query->get('month');
        $year = (int)$request->query->get('year');
        $today = (int)$request->query->get('today');
        $racerId = (int)$request->query->get('racerId');
        if (!$month or !$year) $today = 1;
        if ($today) {
            $year = (int)date("Y");
            $month= (int)date("m");
        }
        $monthName = $this->getFrenchMonthName($month);
        // Nom du Jour en Français
        $arrDayOfWeekName = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

        // Navigation entre les mois
        $nextMonth = $month < 12 ? $month + 1 : 1;
        $nextYear = $month < 12 ? $year : $year + 1;
        $previousMonth = $month > 1 ? $month - 1 : 12;
        $previousYear = $month > 1 ? $year : $year - 1;

        // Choix du coureur
        $racer = null;
        if ($racerId)
        {
            $racer = $em->getRepository(Racer::class)->find(['id' => $racerId]);
        }


        // Construction du calendrier
        $first = getdate(mktime(0, 0, 0, $month, 1, $year)) ;
        // retourne la date du 1er jour du mois
        $ind = ($first['wday']==0?6:$first['wday']-1) ;
        // retourne le numéro d'ordre 1er jour du mois
        $nbjours = date("t", mktime(0, 0, 0, $month, 1, $year)) ;
        // retourne le nombre de jours du mois

        // On rempli le tableau array_mois avec les valeurs
        $numweek=0 ;
        $daysFlags = [];
        for($numjour=1;$numjour<=$nbjours;$numjour++)
        {
            $dayFlags = [
                'dayNum' => -1,
                'dayName' => "",
                'monthNum' => -1,
                'monthName' => "",
                'yearNum' => -1,
                'vacance' => false,
                'sortie' => false,
                'eventTitle' => "",
                'transportAller' => -1, // -1 ne pas afficher ; 0 coureur ko ; 1 coureur ok
                'transportRetour' => -1,
                'dinner'=> -1,
                'night' => -1,
                'skipass' => -1,
                'ski' => -1,
                'skidayType' => "",
                'location' => "",
                'skidayId' => -1,
                'accomodationRacerId' => -1,
                'accomodationId' => -1,
                'skidayRacerId' => -1,
                'transportAllerId' >= -1,
                'transportRacerAllerId' => -1,
                'transportRetourId' >= -1,
                'transportRacerRetourId' => -1,
                'eventId' => -1,
                'dateTimeDay' => new DateTime(),
                'racerId' => -1
                ]
            ;

            $dayFlags['dayNum'] = $numjour;
            $dayFlags['monthNum'] = $month;
            $dayFlags['monthName'] = $monthName;
            $dayFlags['yearNum'] = $year;
            $dayFlags['dayName'] = $arrDayOfWeekName[$ind];
            $dayFlags['dateTimeDay']->setDate($year, $month, $numjour)->setTime(0,0,0);
            if ($racer) $dayFlags['racerId'] = $racer->getId();

            $events = $em->getRepository(Event::class)->findByDate($dayFlags['dateTimeDay']);
            foreach ($events as $event)
            {
                if ($event->getType() == "Vacances scolaires")
                {
                    $dayFlags['vacance'] = true;
                    $dayFlags['eventId'] = $event->getId();
                }
                else
                {
                    $dayFlags['eventId'] = $event->getId();
                    $dayFlags['sortie'] = true;
                }

                $eventStartDayNum = (int)$event->getStartdate()->format('j');
                $eventEndDayNum = (int)$event->getEnddate()->format('j');

                if ($eventStartDayNum == $dayFlags['dayNum'] and $event->getTitle())
                    $dayFlags['eventTitle'] = $event->getTitle();

                # Transport aller
                if ($eventStartDayNum == $dayFlags['dayNum'] and $dayFlags['sortie'])
                {
                    $transportAller = $em->getRepository(Transport::class)->findOneByEvent($event,"Aller");
                    if ($transportAller)
                    {
                        $dayFlags['transportAllerId'] = $transportAller->getId();
                        $dayFlags['transportAller'] = 0;
                        if ($racer)
                        {
                            $transportRacerRegistration = $em->getRepository(TransportRacer::class)->getRacerRegistration($racer,$transportAller);
                            if ($transportRacerRegistration) $dayFlags['transportRacerAllerId'] = $transportRacerRegistration->getId();
                            if ($transportRacerRegistration and $transportRacerRegistration->isRacerPlace()) $dayFlags['transportAller'] = 1;
                        }
                    }
                }

                # Transport retour
                if ($eventEndDayNum == $dayFlags['dayNum'] and $dayFlags['sortie'])
                {
                    $transportRetour = $em->getRepository(Transport::class)->findOneByEvent($event,"Retour");
                    if ($transportRetour)
                    {
                        $dayFlags['transportRetourId'] = $transportRetour->getId();
                        $dayFlags['transportRetour'] = 0;
                        if ($racer)
                        {
                            $transportRacerRegistration = $em->getRepository(TransportRacer::class)->getRacerRegistration($racer,$transportRetour);
                            if ($transportRacerRegistration) $dayFlags['transportRacerRetourId'] = $transportRacerRegistration->getId();
                            if ($transportRacerRegistration and $transportRacerRegistration->isRacerPlace()) $dayFlags['transportRetour'] = 1;
                        }
                    }
                }

                # Nuitée
                $accomodation = $em->getRepository(Accomodation::class)->findOneByEventAndDate($event,$dayFlags['dateTimeDay']);
                if ($accomodation)
                {
                    $dayFlags['accomodationId'] = $accomodation->getId();
                    $dayFlags['night'] = 0;
                    $accomodationRacerRegistration = null;
                    if ($racer)
                        $accomodationRacerRegistration = $em->getRepository(AccomodationRacer::class)->getRacerRegistration($racer,$accomodation);
                    if ($accomodationRacerRegistration) $dayFlags['accomodationRacerId'] = $accomodationRacerRegistration->getId();
                    if ($accomodationRacerRegistration and $accomodationRacerRegistration->isRacerPlace()) $dayFlags['night'] = 1;
                }
            }

            $skiday = $em->getRepository(Skiday::class)->findOneByDate($dayFlags['dateTimeDay']);
            if ($skiday)
            {
                $dayFlags['dinner'] = 0;
                $dayFlags['ski'] = 0;
                $dayFlags['skipass'] = 0;
                $dayFlags['skidayId'] = $skiday->getId();
                $dayFlags['location'] = $skiday->getLocation();
                $dayFlags['skidayType'] = $skiday->getDayType();


                # Repas
                if ($racer)
                {
                    $skidayRacerRegistration = $em->getRepository(SkidayRacer::class)->getRacerRegistration($racer,$skiday);
                    if ($skidayRacerRegistration)
                    {

                        $dayFlags['skidayRacerId'] = $skidayRacerRegistration->getId();
                        if ($skidayRacerRegistration) $dayFlags['skidayRacerId'] = $skidayRacerRegistration->getId();
                        if ($skidayRacerRegistration->isLunchRacer()) $dayFlags['dinner'] = 1;
                        if ($skidayRacerRegistration->isTrainingRacer()) $dayFlags['ski'] = 1;
                        if ($skidayRacerRegistration->isSkipassRacer()) $dayFlags['skipass'] = 1;

                    }
                }
            }

            $daysFlags[$numweek][$ind]=$dayFlags ;

            $ind++ ;
            if($ind==7) {
                $numweek++; $ind=0 ;
            }
        }

        //dd($daysFlags);

        // Famille active (via login)
        $family = null;
        if ($this->getUser())
        {
            $family = $em->getRepository(Family::class)->findOneByLogin($this->getUser()->getEmail());
        }


        return $this->render('planning/index.html.twig', [
            'controller_name' => 'PlanningController',
            'monthName' => $monthName,
            'monthNum' => $month,
            'year' => $year,
            'daysFlags' => $daysFlags,
            'nextMonth' => $nextMonth,
            'nextYear' => $nextYear,
            'previousMonth' => $previousMonth,
            'previousYear' => $previousYear,
            'arrDayOfWeekName' => $arrDayOfWeekName,
            'racer' => $racer,
            'family' => $family,
            'racerId' => $racerId
        ]);
    }

    public function checkEditCredentials($racer,EntityManagerInterface $em)
    {
        if ($racer)
        {
            $authUserfamily = $em->getRepository(Family::class)->findOneByLogin($this->getUser()->getEmail());
            if ($authUserfamily->getId() != $racer->getFamily()->getId())
                throw new AccessDeniedException('Opération interdite pour un coureur hors famille connectée !');
        }
        else
        {
            throw new AccessDeniedException('Opération interdite si pas de coureur sélectionné');
        }
    }

    public function checkEditDelay(DateTime $eventDate,EntityManagerInterface $em)
    {
        // ok si plus de délais entre $eventDate et la date courante que le nombre de jours défini dans le paramètre
        $lockDelay = $em->getRepository(Parameter::class)->getLockDelay();
        $currenTimestamp = time();
        $eventTimestamp = $eventDate->getTimestamp();

        $delta = ($eventTimestamp - $currenTimestamp)/86400;
        if ($delta > $lockDelay)
            return true;
        else
            return false;
    }

    public function verifyEventRacerOrCreate(Event $event, Racer $racer, EntityManagerInterface $em)
    {
        $eventRacer = $em->getRepository(EventRacer::class)->findOneByEventAndRacer($event,$racer);
        if (!$eventRacer)
        {
            $eventRacer = (new EventRacer())
                ->setEvent($event)
                ->setRacer($racer)
                ->setValidated(false)
            ;
            $em->persist($eventRacer);
            $em->flush();
        }
    }

    #[Route('/planning/SkidayOptions', name: 'SkidayOptions')]
    public function SkidayOptions(Request $request,EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // récupération des id
        $racer = null;
        $skidayRacer = null;
        $accomodationRacer = null;
        $transportAllerRacer = null;
        $transportRetourRacer = null;
        $skidayOptions = new SkidayOptions();



        if ($request->query->get('skidayRacerId')) $skidayOptions->skidayRacerId = (int)$request->query->get('skidayRacerId');
        if ($request->query->get('accomodationRacerId')) $skidayOptions->accomodationRacerId = (int)$request->query->get('accomodationRacerId');
        if ($request->query->get('transportRacerAllerId')) $skidayOptions->transportRacerAllerId = (int)$request->query->get('transportRacerAllerId');
        if ($request->query->get('transportRacerRetourId')) $skidayOptions->transportRacerRetourId = (int)$request->query->get('transportRacerRetourId');
        if ($request->query->get('racerId')) $skidayOptions->racerId = (int)$request->query->get('racerId');

        if ($skidayOptions->racerId > -1) $racer = $em->getRepository(Racer::class)->find($skidayOptions->racerId);
        if ($skidayOptions->skidayRacerId > -1) $skidayRacer = $em->getRepository(SkidayRacer::class)->find($skidayOptions->skidayRacerId);
        if ($skidayOptions->accomodationRacerId > -1) $accomodationRacer = $em->getRepository(AccomodationRacer::class)->find($skidayOptions->accomodationRacerId);
        if ($skidayOptions->transportRacerAllerId > -1) $transportAllerRacer = $em->getRepository(TransportRacer::class)->find($skidayOptions->transportRacerAllerId);
        if ($skidayOptions->transportRacerRetourId > -1) $transportRetourRacer = $em->getRepository(TransportRacer::class)->find($skidayOptions->transportRacerRetourId);

        if (isNull($racer))
        {
            if ($skidayRacer)
                $racer = $skidayRacer->getRacer();
            elseif ($accomodationRacer)
                $racer = $accomodationRacer->getRacer();
            elseif ($transportAllerRacer)
                $racer = $transportAllerRacer->getRacer();
            elseif ($transportRetourRacer)
                $racer = $transportAllerRacer->getRacer();
        }

        $infos = [];

        //check credential
        $this->checkEditCredentials($racer,$em);

        if ($skidayRacer)
        {
            $infos['dayDate']= $skidayRacer->getSkiday()->getDayDate();
            $infos['dayType']= $skidayRacer->getSkiday()->getDayType();
            $infos['location']= $skidayRacer->getSkiday()->getLocation();
            $infos['racer']= $skidayRacer->getRacer()->__toString();
            $skidayOptions->skipassNonracerCount = $skidayRacer->getSkipassNonracerCount();
        }
        if ($accomodationRacer)
        {
            $infos['accomodation']= $accomodationRacer->getAccomodation()->getLocation();
            $skidayOptions->accomodationNonracerPlaceCount = $accomodationRacer->getNonracerPlaceCount();
        }
        if ($transportAllerRacer)
        {
            $skidayOptions->transportAllerNonracerPlaceCount = $transportAllerRacer->getNonracerPlaceCount();
            $skidayOptions->transportAllerAvailablePlaceCount = $transportAllerRacer->getAvailablePlaceCount();
        }
        if ($transportRetourRacer)
        {
            $skidayOptions->transportRetourNonracerPlaceCount = $transportRetourRacer->getNonracerPlaceCount();
            $skidayOptions->transportRetourAvailablePlaceCount = $transportRetourRacer->getAvailablePlaceCount();
        }


        $form = $this->createForm(SkidayOptionsType::class,$skidayOptions);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $skidayOptions = $form->getData();

            if ($skidayOptions->skipassNonracerCount > -1)
            {
                $skidayRacer = $em->getRepository(SkidayRacer::class)->find($skidayOptions->skidayRacerId);
                $skidayRacer->setSkipassNonracerCount($skidayOptions->skipassNonracerCount);
            }
            if ($skidayOptions->accomodationNonracerPlaceCount > -1)
            {
                $accomodationRacer = $em->getRepository(AccomodationRacer::class)->find($skidayOptions->accomodationRacerId);
                $accomodationRacer->setNonracerPlaceCount($skidayOptions->accomodationNonracerPlaceCount);
            }
            if ($skidayOptions->transportAllerNonracerPlaceCount > -1 or $skidayOptions->transportAllerAvailablePlaceCount > -1)
            {
                $transportAllerRacer = $em->getRepository(TransportRacer::class)->find($skidayOptions->transportRacerAllerId);
                $transportAllerRacer->setNonracerPlaceCount($skidayOptions->transportAllerNonracerPlaceCount);
                $transportAllerRacer->setAvailablePlaceCount($skidayOptions->transportAllerAvailablePlaceCount);
            }
            if ($skidayOptions->transportRetourNonracerPlaceCount > -1 or $skidayOptions->transportRetourAvailablePlaceCount > -1)
            {
                $transportRetourRacer = $em->getRepository(TransportRacer::class)->find($skidayOptions->transportRacerRetourId);
                $transportRetourRacer->setNonracerPlaceCount($skidayOptions->transportRetourNonracerPlaceCount);
                $transportRetourRacer->setAvailablePlaceCount($skidayOptions->transportRetourAvailablePlaceCount);
            }

            $em->flush();

            return $this->redirectToRoute('app_planning',[
                'racerId'=> $skidayOptions->racerId,
                'month'=> (int)$infos['dayDate']->format('m'),
                'year'=> (int)$infos['dayDate']->format('Y'),
            ]);
        }

        return $this->render('planning/options.html.twig', [
            'form' => $form, 'infos' => $infos
        ]);
    }

    #[Route('/planning/ToggleTransport/{transportRacerId}', name: 'ToggleTransport')]
    public function ToggleTransport(int $transportRacerId, Request $request,EntityManagerInterface $em): Response
    {
        $transportRacer = null;
        if ($transportRacerId > 0)
        {
            // Le transportRacer existe déjà
            $transportRacer = $em->getRepository(TransportRacer::class)->find($transportRacerId);
        }
        else
        {
            // Le transportRacer n'existe pas -> le créer
            $transportId = (int)$request->query->get('transportId');
            $racerId = (int)$request->query->get('racerId');
            $transport = $em->getRepository(Transport::class)->find($transportId);
            $racer = $em->getRepository(Racer::class)->find($racerId);
            $transportRacer = (new TransportRacer())
                ->setTransport($transport)
                ->setRacer($racer)
                ->setRacerPlace(false)
                ->setNonracerPlaceCount(0)
                ->setAvailablePlaceCount(0);
            $em->persist($transportRacer);
            $em->flush();
        }

        //A t on le droit de modifier ?
        $this->checkEditCredentials($transportRacer->getRacer(),$em);
        if (!$this->checkEditDelay($transportRacer->getTransport()->getEvent()->getStartdate(), $em))
            throw new AccessDeniedException("Hors délais : il n'est plus possible de modifier cette sortie");

        // créer le eventRacer si il n'existe pas
        $this->verifyEventRacerOrCreate($transportRacer->getTransport()->getEvent(),$transportRacer->getRacer(),$em);

        // Modification
        if ($transportRacer->isRacerPlace())
            $transportRacer->setRacerPlace(false);
        else
            $transportRacer->setRacerPlace(true);
        $em->flush();

        // Re-affichage après modification
        $direction = $transportRacer->getTransport()->getDirection();
        $dayDate = new DateTime();
        if ($direction == "Aller") $dayDate = $transportRacer->getTransport()->getEvent()->getStartdate();
        if ($direction == "Retour") $dayDate = $transportRacer->getTransport()->getEvent()->getEnddate();
        $month = $dayDate->format("m");
        $year = $dayDate->format("Y");
        return $this->redirectToRoute('app_planning',[
            'racerId'=> $transportRacer->getRacer()->getId(),
            'month'=> $month,
            'year'=> $year,
        ]);

    }



    #[Route('/planning/ToggleAccomodation/{accomodationRacerId}', name: 'ToggleAccomodation')]
    public function ToggleAccomodation(int $accomodationRacerId, Request $request,EntityManagerInterface $em): Response
    {
        $accomodationRacer = null;
        if ($accomodationRacerId > 0)
        {
            // Le accomodationRacer existe déjà
            $accomodationRacer = $em->getRepository(AccomodationRacer::class)->find($accomodationRacerId);
        }
        else
        {
            // Le accomodationRacer n'existe pas -> le créer
            $accomodationId = (int)$request->query->get('accomodationId');
            $accomodation = $em->getRepository(Accomodation::class)->find($accomodationId);
            $racerId = (int)$request->query->get('racerId');
            $racer = $em->getRepository(Racer::class)->find($racerId);

            $accomodationRacer = (new AccomodationRacer())
                ->setAccomodation($accomodation)
                ->setRacer($racer)
                ->setRacerPlace(false)
                ->setNonracerPlaceCount(0);

            $em->persist($accomodationRacer);
            $em->flush();
        }

        //A t on le droit de modifier ?
        $this->checkEditCredentials($accomodationRacer->getRacer(),$em);
        if (!$this->checkEditDelay($accomodationRacer->getAccomodation()->getDayDate(), $em))
            throw new AccessDeniedException("Hors délais : il n'est plus possible de modifier cette sortie");

        // créer le eventRacer si il n'existe pas
        $this->verifyEventRacerOrCreate($accomodationRacer->getAccomodation()->getEvent(),$accomodationRacer->getRacer(),$em);

        // Modification
        if ($accomodationRacer->isRacerPlace())
            $accomodationRacer->setRacerPlace(false);
        else
            $accomodationRacer->setRacerPlace(true);
        $em->flush();


        $dayDate = $accomodationRacer->getAccomodation()->getDayDate();
        $month = $dayDate->format("m");
        $year = $dayDate->format("Y");
        return $this->redirectToRoute('app_planning',[
            'racerId'=> $accomodationRacer->getRacer()->getId(),
            'month'=> $month,
            'year'=> $year,
        ]);

    }

    #[Route('/planning/ToggleLunch/{skidayRacerId}', name: 'ToggleLunch')]
    #[Route('/planning/ToggleTraining/{skidayRacerId}', name: 'ToggleTraining')]
    #[Route('/planning/ToggleSkipass/{skidayRacerId}', name: 'ToggleSkipass')]
    public function ToggleSkiday(int $skidayRacerId, Request $request,EntityManagerInterface $em): Response
    {
        $skidayRacer = null;
        if ($skidayRacerId > 0)
        {
            // Le skidayRacer existe déjà
            $skidayRacer = $em->getRepository(SkidayRacer::class)->find($skidayRacerId);
        }
        else
        {
            // Le skidayRacer n'existe pas -> le créer
            $skidayId = (int)$request->query->get('skidayId');
            $skiday = $em->getRepository(Skiday::class)->find($skidayId);
            $racerId = (int)$request->query->get('racerId');
            $racer = $em->getRepository(Racer::class)->find($racerId);
            $skidayRacer = (new SkidayRacer())
                ->setSkiday($skiday)
                ->setRacer($racer)
                ->setSkipassRacer(false)
                ->setLunchRacer(false)
                ->setTrainingRacer(false)
                ->setSkipassNonracerCount(0);

            $em->persist($skidayRacer);
            $em->flush();
        }

        //A t on le droit de modifier ?
        $this->checkEditCredentials($skidayRacer->getRacer(),$em);
        if (!$this->checkEditDelay($skidayRacer->getSkiday()->getDayDate(), $em))
            throw new AccessDeniedException("Hors délais : il n'est plus possible de modifier cette sortie");

        // créer le eventRacer si il n'existe pas
        $this->verifyEventRacerOrCreate($skidayRacer->getSkiday()->getEvent(),$skidayRacer->getRacer(),$em);


        $routeName = $request->attributes->get('_route');
        //$this->addFlash('success', 'ToggleSkiday - rn = '.$routeName);

        if ($routeName == 'ToggleLunch')
        {
            if ($skidayRacer->isLunchRacer())
                $skidayRacer->setLunchRacer(false);
            else
                $skidayRacer->setLunchRacer(true);
        }
        if ($routeName == 'ToggleSkipass')
        {
            if ($skidayRacer->isSkipassRacer())
                $skidayRacer->setSkipassRacer(false);
            else
                $skidayRacer->setSkipassRacer(true);
        }
        if ($routeName == 'ToggleTraining')
        {
            if ($skidayRacer->isTrainingRacer())
            {
                $skidayRacer->setTrainingRacer(false);
            }
            else
            {
                $skidayRacer->setTrainingRacer(true);
            }
        }
        $em->flush();

        $dayDate = $skidayRacer->getSkiday()->getDayDate();
        $month = $dayDate->format("m");
        $year = $dayDate->format("Y");
        return $this->redirectToRoute('app_planning',[
            'racerId'=> $skidayRacer->getRacer()->getId(),
            'month'=> $month,
            'year'=> $year,
        ]);

    }

    #[Route('/planning/summary', name: 'day_summary')]
    #[Route('/planning/printsummary', name: 'day_summary_print')]
    public function ShowSummary(Request $request,EntityManagerInterface $em): Response
    {
        $routeName = $request->attributes->get('_route');
        $skidayId = -1;
        $eventId = -1;
        $eventId = $request->query->get('eventId');
        $skidayId = (int)$request->query->get('skidayId');
        $title = "";
        $dayStart = new datetime();
        $dayEnd = new datetime();
        $event = null;

        if ($skidayId > 0)
        {
            //dd($skidayId);
            $title = "Jour de ski";
        }
        else
        {
            //dd($eventId);
            $title = "période";
            $event = $em->getRepository(Event::class)->find($eventId);
            if (! $event)
                throw $this->createNotFoundException('Sortie non trouvée');
            $dayStart = $event->getStartdate();
            $dayEnd = $event->getEnddate();

        }

        return $this->render('planning/summary.html.twig', [
            'title' => $title,
            'event' => $event,
            'routeName' => $routeName

        ]);
    }

    public function append(String &$base, String $add)
    {
        if (strlen($base) > 0)
            $base = $base."|";

        if (strlen($add) > 0)
        {
            $base = $base.$add;
        }
    }

    public function ComputeImputation(Event $event, EntityManagerInterface $em)
    {
        $transports = $event->getTransports();
        $accomodations  = $event->getAccomodations();
        $skidays = $event->getSkidays();

        // prix du transport unitaire
        $transportCost = $em->getRepository(Parameter::class)->getTransportCost();
        if ($transportCost == 0) throw $this->createNotFoundException('TransportCost non paramétré');

        $racers = $em->getRepository(Racer::class)->findByEvent($event);

        $racersData = [];

        foreach ($racers as $racer)
        {
            $racerData['id'] = $racer->getId();
            $racerData['name'] = $racer->__toString();
            $racerData['memo'] = [];
            $racerData['cntTransport'] = 0;
            $racerData['transportCost'] = $transportCost;
            $racerData['cntAccomodationR'] = 0;
            $racerData['cntAccomodationNR'] = 0;
            $racerData['accomodationNRCost'] = 0;
            $racerData['cntLunch'] = 0;
            $racerData['lunchCost'] = 0;
            $racerData['cntSkipassR'] = 0;
            $racerData['cntSkipassNR'] = 0;
            $racerData['skipassNRCost'] = 0;
            $racerData['cntTraining'] = 0;
            $racerData['priceTemplateName'] = '';
            $racerData['imputationDone'] = false;
            $racerData['totalPrice'] = 0;


            $eventRacer = $em->getRepository(EventRacer::class)->findOneByEventAndRacer($event,$racer);
            if ($eventRacer)
                $racerData['imputationDone'] = $eventRacer->isValidated();


            foreach ($transports as $transport)
            {
                $transportRacer = $em->getRepository(TransportRacer::class)->getRacerRegistration($racer,$transport);
                if ($transportRacer and $transportRacer->isRacerPlace())
                {
                    $racerData['memo'][] = "Transport ".$transport->getDirection()." 1 place coureur";
                    $racerData['cntTransport']++;
                }
                if ($transportRacer and $transportRacer->getNonracerPlaceCount() > 0)
                {
                    $racerData['memo'][] = "Transport ".$transport->getDirection()." ".$transportRacer->getNonracerPlaceCount()." place(s) hors coureur";
                    $racerData['cntTransport'] += $transportRacer->getNonracerPlaceCount();
                }
            }
            // pour le transport, on compte par paire non divisible
            $racerData['cntTransport'] = ceil($racerData['cntTransport']/2);

            foreach ($accomodations as $accomodation)
            {
                $accomodationRacer = $em->getRepository(AccomodationRacer::class)->getRacerRegistration($racer,$accomodation);
                if ($accomodationRacer and $accomodationRacer->isRacerPlace())
                {
                    $racerData['memo'][] = "Hébergement le ".$accomodation->getDayDate()->format("d/m/Y")." 1 place coureur";
                    $racerData['cntAccomodationR']++;
                }
                if ($accomodationRacer and $accomodationRacer->getNonracerPlaceCount())
                {
                    $racerData['memo'][] = "Hébergement le ".$accomodation->getDayDate()->format("d/m/Y")." ".$accomodationRacer->getNonracerPlaceCount() ." place(s) hors coureur à ".$accomodation->getPrice()."€";;
                    $racerData['cntAccomodationNR'] += $accomodationRacer->getNonracerPlaceCount();
                    if ($accomodation->getPrice() == 0) throw $this->createNotFoundException('Tarif nuité hors coureur non spécifiée pour cette soirée');
                    $racerData['accomodationNRCost'] +=$accomodation->getPrice() * $accomodationRacer->getNonracerPlaceCount();

                }
            }
            foreach ($skidays as $skiday)
            {
                $skidayRacer = $em->getRepository(SkidayRacer::class)->getRacerRegistration($racer,$skiday);
                if ($skidayRacer and $skidayRacer->isTrainingRacer())
                {
                    $racerData['memo'][] = "Entrainement le ".$skiday->getDayDate()->format("d/m/Y");
                    $racerData['cntTraining']++;
                }
                if ($skidayRacer and $skidayRacer->isSkipassRacer())
                {
                    $racerData['memo'][] = "Forfait coureur le ".$skiday->getDayDate()->format("d/m/Y");
                    $racerData['cntSkipassR']++;
                }
                if ($skidayRacer and $skidayRacer->getSkipassNonracerCount()>0)
                {
                    $racerData['memo'][] = $skidayRacer->getSkipassNonracerCount(). " Forfait(s) non coureur le ".$skiday->getDayDate()->format("d/m/Y")." à ".$skiday->getSkipassPrice()."€";
                    $racerData['cntSkipassNR']+=$skidayRacer->getSkipassNonracerCount();
                    $racerData['skipassNRCost'] +=$skidayRacer->getSkipassNonracerCount() * $skiday->getSkipassPrice();
                }
                if ($skidayRacer and $skidayRacer->isLunchRacer())
                {
                    $racerData['cntLunch']++;
                    if ($skiday->getLunchPrice())
                    {
                        $racerData['lunchCost']+=$skiday->getLunchPrice();
                        $racerData['memo'][] = "Repas coureur le ".$skiday->getDayDate()->format("d/m/Y")." à ".$skiday->getLunchPrice()."€";
                    }
                    else
                    {
                        $defaultLunchCost = $em->getRepository(Parameter::class)->getDefaultLunchCost();
                        if ($defaultLunchCost == 0) throw $this->createNotFoundException('DefaultLunchCost non paramétré');
                        $racerData['lunchCost']+=$defaultLunchCost;
                        $racerData['memo'][] = "Repas coureur le ".$skiday->getDayDate()->format("d/m/Y")." à ".$defaultLunchCost."€ (par défaut)";

                    }
                }
            }

            // recherche du tarif correspondant
            $priceTemplate = $em->getRepository(Pricetemplate::class)->findOneByParameters($racerData['cntTraining'], $racerData['cntAccomodationR'], $racerData['cntSkipassR']);
            if ($priceTemplate)
            {
                $racerData['priceTemplateName'] = $priceTemplate->getName()." (".$priceTemplate->getPrice()."€)";
            }
            else
            {
                $racerData['priceTemplateName'] = "Pas de formule trouvé";
            }

            // Prix total
            if ($priceTemplate)
            {
                $racerData['totalPrice'] = $racerData['lunchCost'] +
                    $transportCost * $racerData['cntTransport'] +
                    $priceTemplate->getPrice() +
                    $racerData['skipassNRCost'] +
                    $racerData['accomodationNRCost']
                ;
            }

            else
                $racerData['totalPrice'] = 'na.';

            $racersData[] = $racerData;
        }
        return $racersData;

    }

    #[Route('/planning/imputation/{eventId}', name: 'imputation')]
    public function ShowImputation(int $eventId, Request $request,EntityManagerInterface $em): Response
    {
        if ($eventId == 0)
            throw $this->createNotFoundException('Sortie non spécifiée');
        $event = $em->getRepository(Event::class)->find($eventId);

        $racersData = $this->ComputeImputation($event, $em);

        return $this->render('planning/imputation.html.twig',
            [
                'event'=>$event,
                'racersData' => $racersData,
        ]);
    }

    #[Route('/planning/imputate/{eventId}', name: 'apply_imputation')]
    public function ApplyImputation(int $eventId, Request $request,EntityManagerInterface $em): Response
    {
        if ($eventId == 0)
            throw $this->createNotFoundException('Sortie non spécifiée');
        $event = $em->getRepository(Event::class)->find($eventId);
        if (!$event)
            throw $this->createNotFoundException('Erreur sps : Sortie non trouvée avec le code '.$eventId);

        // calcule les données d'imputation
        $racersData = $this->ComputeImputation($event, $em);

        // nettoyage des éventuelles imputations déjà enregistrées pour cette sortie
        foreach ($event->getAccountings() as $item)
        {
            $em->remove($item);
        }
        $em->flush();

        foreach ($racersData as $racerData)
        {
            $racer = $em->getRepository(Racer::class)->find($racerData['id']);
            if (!$event)
                throw $this->createNotFoundException('Erreur sps : Coureur non trouvé avec le code '.$racerData['id']);
            $accountingItem = new Accounting();
            $accountingItem->setEvent($event);
            $accountingItem->setEvent($event);
            $accountingItem->setImputationDate($event->getEnddate());
            $accountingItem->setRacer($racer);
            $accountingItem->setFamily($racer->getFamily());
            $accountingItem->setUsername($this->getUser()->getEmail());
            $accountingItem->setReason('Imputation sortie - '.$event->__toString().' - '.$racer->__toString());
            if ($racerData['totalPrice'] == 'na.')
                throw $this->createNotFoundException('Erreur : Imputation impossible car pas de formule trouvée pour '.$racer->__toString());
            $accountingItem->setValue(-$racerData['totalPrice']);
            $em->persist($accountingItem);
            $eventRacer = $em->getRepository(EventRacer::class)->findOneByEventAndRacer($event,$racer);
            if (!$eventRacer)
                throw $this->createNotFoundException('Erreur sps : Sortie Courreur non trouvée pour le coureur '.$racerData['id'].' sortie '.$eventId);
            $eventRacer->setValidated(true);
            //todo:valider l'imputation dans eventracer
        }

        $em->flush();
        $this->addFlash('success','Imputation faite avec succès');
        return $this->redirectToRoute("imputation",['eventId' => $event->getId()]);
    }

    public function getFrenchMonthName($monthNum): String
    {
        // Nom du Mois en Français
        $monthName = "";
        switch($monthNum) {
            case 1 : $monthName = "Janvier" ; break ;
            case 2 : $monthName = "Fevrier" ; break ;
            case 3 : $monthName = "Mars" ; break ;
            case 4 : $monthName = "Avril" ; break ;
            case 5 : $monthName = "Mai" ; break ;
            case 6 : $monthName = "Juin" ; break ;
            case 7 : $monthName = "Juillet" ; break ;
            case 8 : $monthName = "Aout" ; break ;
            case 9 : $monthName = "Septembre" ; break ;
            case 10 : $monthName = "Octobre" ; break ;
            case 11 : $monthName = "Novembre" ; break ;
            case 12 : $monthName = "Decembre" ; break ;
        }
        return $monthName;
    }
}
