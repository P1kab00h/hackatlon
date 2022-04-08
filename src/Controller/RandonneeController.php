<?php

namespace App\Controller;

use App\Entity\Hike;
use App\Repository\HikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class RandonneeController extends AbstractController
{
    #[Route('/randonnee', name: 'app_randonnee')]
    public function index(): Response
    {
        return $this->render('randonnee/index.html.twig', [
            'controller_name' => 'RandonneeController',
        ]);
    }

    #[Route('/randonnee_facile', name: 'randonnee_facile')]
    public function randonneeFacile(): Response
    {
        return $this->render('randonnee/randonneeFacile.html.twig', [
            'controller_name' => 'randonneeFacile',
        ]);
    }
    #[Route('/randonnee_moyenne', name: 'randonnee_moyenne')]
    public function randonneeMoyenne(): Response
    {
        return $this->render('randonnee/randonneeMoyenne.html.twig', [
            'controller_name' => 'randonneeMoyenne',
        ]);
    }
    #[Route('/randonnee_difficile', name: 'randonnee_difficile')]
    public function randonneeDifficile(): Response
    {
        return $this->render('randonnee/randonneeDifficile.html.twig', [
            'controller_name' => 'randonneeDifficile',
        ]);
    }

    #[Route('/randonneeFetchRender', name: 'randonneeFetchRender', methods: ['GET'])]
    public function randonneeFetchRender(HikeRepository $hikeRepository, NormalizerInterface $normalizer): Response
    {
        return $this->json($normalizer->normalize($hikeRepository->findAll(), null, ['groups' => 'hike:read']));
    }

    #[Route('/{nameSlugger}', name: 'randonne_detail_show', methods: ['GET'])]
    public function show(Hike $hike): Response
    {
        return $this->render('randonnee/randonneeDetail.html.twig', [
            'hike' => $hike,
        ]);
    }
}
