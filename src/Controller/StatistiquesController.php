<?php

namespace App\Controller;

use App\Entity\ServiceSearch;
use App\Form\ServiceSearchFormType;
use App\Repository\ServiceRepository;
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

        return $this->render('pages/statistiques/index.html.twig', [
            'services' => $services,
            'form' => $form->createView()
        ]);
    }
    
}