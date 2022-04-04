<?php

namespace App\Controller;

use App\Entity\Difficulty;
use App\Form\DifficultyType;
use App\Repository\DifficultyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/difficulty')]
class DifficultyController extends AbstractController
{
    #[Route('/', name: 'app_difficulty_index', methods: ['GET'])]
    public function index(DifficultyRepository $difficultyRepository): Response
    {
        return $this->render('difficulty/index.html.twig', [
            'difficulties' => $difficultyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_difficulty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DifficultyRepository $difficultyRepository): Response
    {
        $difficulty = new Difficulty();
        $form = $this->createForm(DifficultyType::class, $difficulty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $difficultyRepository->add($difficulty);
            return $this->redirectToRoute('app_difficulty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('difficulty/new.html.twig', [
            'difficulty' => $difficulty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_difficulty_show', methods: ['GET'])]
    public function show(Difficulty $difficulty): Response
    {
        return $this->render('difficulty/show.html.twig', [
            'difficulty' => $difficulty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_difficulty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Difficulty $difficulty, DifficultyRepository $difficultyRepository): Response
    {
        $form = $this->createForm(DifficultyType::class, $difficulty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $difficultyRepository->add($difficulty);
            return $this->redirectToRoute('app_difficulty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('difficulty/edit.html.twig', [
            'difficulty' => $difficulty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_difficulty_delete', methods: ['POST'])]
    public function delete(Request $request, Difficulty $difficulty, DifficultyRepository $difficultyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$difficulty->getId(), $request->request->get('_token'))) {
            $difficultyRepository->remove($difficulty);
        }

        return $this->redirectToRoute('app_difficulty_index', [], Response::HTTP_SEE_OTHER);
    }
}
