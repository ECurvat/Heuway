<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use App\Repository\ContratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContratController extends AbstractController
{
    #[Route('/contrat', name: 'contrat.index')]
    public function index(
        ContratRepository $repository, 
        Request $request, 
        PaginatorInterface $paginator
        ) : Response
    {
        $contrats = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), 
            6 
        );

        return $this->render('pages/contrat/index.html.twig', [
            'contrats' => $contrats,
        ]);
    }

    #[Route ('/contrat/nouveau', 'contrat.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ) : Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contrat = $form->getData();

            $manager->persist($contrat);
            $manager->flush();

            $this->addFlash('success', 'Le contrat a bien été créé !');
            return $this->redirectToRoute('contrat.index');
        }

        return $this->render('pages/contrat/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
