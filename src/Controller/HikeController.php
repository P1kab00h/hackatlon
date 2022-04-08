<?php

namespace App\Controller;

use App\Entity\Hike;
use App\Form\HikeType;
use App\Repository\HikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/hike')]
class HikeController extends AbstractController
{
    #[Route('/', name: 'app_hike_index', methods: ['GET'])]
    public function index(HikeRepository $hikeRepository): Response
    {
        return $this->render('hike/index.html.twig', [
            'hikes' => $hikeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hike_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $hike = new Hike();
        $form = $this->createForm(HikeType::class, $hike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $hikeRepository->add($hike);

            $hike->setNameSlugger($slugger->slug($hike->getName()));
            $entityManager->persist($hike);
            $entityManager->flush();

            $this->addFlash('notice', 'Nouvelle randonnée enregistré');
            return $this->redirectToRoute('app_hike_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('hike/new.html.twig', [
            'hike' => $hike,
            'form' => $form,
        ]);
    }


    #[Route('/{nameSlugger}', name: 'app_hike_show', methods: ['GET'])]
    public function show(Hike $hike): Response
    {
        return $this->render('hike/show.html.twig', [
            'hike' => $hike,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hike_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hike $hike, HikeRepository $hikeRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(HikeType::class, $hike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $hikeRepository->add($hike);

        $hike->setNameSlugger($slugger->slug($hike->getName()));
        $entityManager->persist($hike);
        $entityManager->flush();
            return $this->redirectToRoute('app_hike_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('hike/edit.html.twig', [
            'hike' => $hike,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hike_delete', methods: ['POST'])]
    public function delete(Request $request, Hike $hike, HikeRepository $hikeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $hike->getId(), $request->request->get('_token'))) {
            $hikeRepository->remove($hike);
        }

        return $this->redirectToRoute('app_hike_index', [], Response::HTTP_SEE_OTHER);
    }
}
