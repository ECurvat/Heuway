<?php

namespace App\Controller;

use App\Entity\ServiceSearch;
use App\Form\ServiceSearchFormType;
use App\Repository\ServiceRepository;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiquesController extends AbstractController {
    
    #[Route('/statistiques', name: 'statistiques.index')]
    public function index(ServiceRepository $repository, Request $request): Response
    {
        $search = new ServiceSearch();
        $form = $this->createForm(ServiceSearchFormType::class, $search);
        $form->handleRequest($request);

        $services = $repository->findAllVisibleQuery($search)->getResult();

        function compareDateIntervalDuration($interval1, $interval2) {
            $seconds1 = $interval1->s + 60 * ($interval1->i + 60 * ($interval1->h + 24 * $interval1->d));
            $seconds2 = $interval2->s + 60 * ($interval2->i + 60 * ($interval2->h + 24 * $interval2->d));
            if ($seconds1 > $seconds2) {
                return 1;
            } elseif ($seconds1 < $seconds2) {
                return -1;
            } else {
                return 0;
            }
        }

        $secondesDuree = 0;
        $secondesPause = 0;
        $secondesDispo = 0;
        $secondesDeplacement = 0;
        $secondesCoupure = 0;
        $secondesNuit = 0;
        function addToCount($service, $secondesDuree, $secondesPause, $secondesDispo, $secondesDeplacement, $secondesCoupure, $secondesNuit) {
            $secondesDuree += $service->getFin()->diff($service->getDebut())->format('%I') * 60 + $service->getFin()->diff($service->getDebut())->format('%h') * 3600;
            $secondesPause += $service->getPause()->format('i') * 60 + $service->getPause()->format('H') * 3600;
            $secondesDispo += $service->getDispo()->format('i') * 60 + $service->getDispo()->format('H') * 3600;
            $secondesDeplacement += $service->getDeplacement()->format('i') * 60 + $service->getDeplacement()->format('H') * 3600;
            $secondesCoupure += $service->getCoupure()->format('i') * 60 + $service->getCoupure()->format('H') * 3600;
            $nuit = dureeNuit($service);
            $secondesNuit += $nuit[1] * 60 + $nuit[0] * 3600;
            return array($secondesDuree, $secondesPause, $secondesDispo, $secondesDeplacement, $secondesCoupure, $secondesNuit);
        }

        function convertSecondsToHoursMinutes($seconds) {
            $minutes = floor($seconds / 60);
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;
            $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
            $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
            return array($hours, $minutes);
        }

        function dureeNuit($service) {
            $debutNuit = new DateTime('22:00');
            $finNuit = new DateTime('05:00');
            $debut = $service->getDebut();
            $fin = $service->getFin();
            $duree = array("0", "0");
            
            if ($fin->format("H") >= $debutNuit->format("H")) { // Service qui commence à J, et qui termine à J après 22h
                $duree[0] = $fin->format("H") - $debutNuit->format("H");
                $duree[1] = $fin->format("i");
            } else if ($fin->format("d") == ($debut->format("d") + 1)) { // Service qui commence à J, et qui termine à J+1
                $duree[0] = 2 + $fin->format("H");
                $duree[1] = $fin->format("i");
            } else if ($debut->format("H") < $finNuit->format("H")) { // Service qui commence à J avant 4h
                $duree[0] = $finNuit->diff($debut)->format("%h");
                $duree[1] = $finNuit->diff($debut)->format("%I");
            }
            return $duree;
        }

        

        if (!$services) {
            $this->addFlash('danger', 'Aucun service trouvé');
            return $this->redirectToRoute('statistiques.index');
        } else {
            // Pour la durée totale des services et la durée moyenne
            $totalMinutes = 0;
            $totalHeures = 0;
            $pauseMinutes = 0;
            $pauseHeures = 0;

            // Pour le min/max de la durée des services
            $dureeMaximum = DateInterval::createFromDateString('1 second');
            $dureeMinimum = DateInterval::createFromDateString('23 hours');
            foreach ($services as $service) {
                $debut = $service->getDebut();
                $fin = $service->getFin();
                $dureeCourante = $fin->diff($debut);
                $pauseCourante = $service->getPause();
                if(compareDateIntervalDuration($dureeCourante, $dureeMaximum) == 1) {
                    $dureeMaximum = $dureeCourante;
                }
                if(compareDateIntervalDuration($dureeCourante, $dureeMinimum) == -1) {
                    $dureeMinimum = $dureeCourante;
                }
                [$secondesDuree, $secondesPause, $secondesDispo, $secondesDeplacement, $secondesCoupure, $secondesNuit] = addToCount($service, $secondesDuree, $secondesPause, $secondesDispo, $secondesDeplacement, $secondesCoupure, $secondesNuit);
                dureeNuit($service);
            }

            $dureeTotale = convertSecondsToHoursMinutes($secondesDuree);
            $dureeMoyenne = convertSecondsToHoursMinutes($secondesDuree / count($services));
            $dureeMaximum = [$dureeMaximum->format('%h'), $dureeMaximum->format('%I')];
            $dureeMinimum = [$dureeMinimum->format('%h'), $dureeMinimum->format('%I')];
            $pauseMoyenne = convertSecondsToHoursMinutes($secondesPause / count($services));
            $dispoMoyenne = convertSecondsToHoursMinutes($secondesDispo / count($services));
            $deplacementMoyen = convertSecondsToHoursMinutes($secondesDeplacement / count($services));
            $coupureMoyenne = convertSecondsToHoursMinutes($secondesCoupure / count($services));
            $nuitMoyenne = convertSecondsToHoursMinutes($secondesNuit / count($services));

            $stats = [
                'dureeTotale' => $dureeTotale,
                'dureeMoyenne' => $dureeMoyenne,
                'dureeMaximum' => $dureeMaximum,
                'dureeMinimum' => $dureeMinimum,
                'pauseMoyenne' => $pauseMoyenne,
                'dispoMoyenne' => $dispoMoyenne,
                'deplacementMoyen' => $deplacementMoyen,
                'coupureMoyenne' => $coupureMoyenne,
                'nuitMoyenne' => $nuitMoyenne,
            ];
        }        

        return $this->render('pages/statistiques/index.html.twig', [
            'services' => $services,
            'form' => $form->createView(),
            'stats' => $stats,
        ]);
    }
    
}