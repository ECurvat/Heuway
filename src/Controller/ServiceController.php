<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\ServiceSearch;
use App\Form\ServiceSearchFormType;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'service.index')]
    public function index(ServiceRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = new ServiceSearch();
        $form = $this->createForm(ServiceSearchFormType::class, $search);
        $form->handleRequest($request);

        $services = $paginator->paginate(
            $repository->findAllVisibleQuery($search), 
            $request->query->getInt('page', 1), 
            6 
        );

        // passer la variable services à la vue sous le nom de services
        return $this->render('pages/service/index.html.twig', [
            'services' => $services,
            'form' => $form->createView()
        ]);
    }

    #[Route ('/service/nouveau', 'service.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
        ) : Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();

            $manager->persist($service);
            $manager->flush();

            $this->addFlash('success', 'Le service a bien été créé !');
            return $this->redirectToRoute('service.index');
        }

        return $this->render('pages/service/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/service/edit/{id}', name: 'service.edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        $id,
        ServiceRepository $repository
        ) : Response
    {
        $service = $repository->findOneBy(['id' => $id]);
        if (!$service) {
            $this->addFlash('danger', 'Le service demandé n\'existe pas !');

            return $this->redirectToRoute('service.index');
        }
        
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service = $form->getData();

            $manager->persist($service);
            $manager->flush();

            $this->addFlash('success', 'Le service a bien été modifié !');
            return $this->redirectToRoute('service.index');
        }
        
        return $this->render('pages/service/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/service/delete/{id}', name: 'service.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, $id, ServiceRepository $repository) : Response {
        $service = $repository->findOneBy(['id' => $id]);
        if (!$service) {
            $this->addFlash('danger', 'Le service demandé n\'existe pas !');

            return $this->redirectToRoute('service.index');
        }

        $manager->remove($service);
        $manager->flush();

        $this->addFlash('success', 'Le service a bien été supprimé !');

        return $this->redirectToRoute('service.index');
    }
}
