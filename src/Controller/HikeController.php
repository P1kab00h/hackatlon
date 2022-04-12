<?php

namespace App\Controller;

use App\Entity\Hike;
use App\Entity\HikeImages;
use App\Entity\UploadImages;
use App\Form\HikeType;
use App\Repository\HikeRepository;
use App\Service\Telechargement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\Groups;
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
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, Telechargement $telechargement): Response
    {
        $hike = new Hike();
        $form = $this->createForm(HikeType::class, $hike);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // gestion des images (on récupère les images transmises)
            // dans la variables nous allons récupérer dans le form sous la propriétée 'images' les datas
            $images = $form->get('images')->getData();
            if($images) {
                // Une boucle sera nécessaire sur les images (afin de gérer l'ajout multiple)
//               foreach ($images as $image){
                // On stocke le nom de l'image dans la BDD (pour rappel nous ne stockons pas de PJ en BDD)
                // instance de UploadImages
                $img = new HikeImages();
                // On attribut un nom qui sera alors inscrit en BDD (nous utilisons la variable $fichier cf plus haut)
                //puis on upload l'image avec la method créé
                $hikeImageFileName = $telechargement->uploadImg($images);
                $img->setName($hikeImageFileName);
                $hike->addHikeImage($img);
                //On persist la donnée (autre solution la cascade en 'persist' sur l'entity :
                // //    #[ORM\OneToMany(mappedBy: 'hike', targetEntity: HikeImages::class, orphanRemoval: true, cascade: ["persist"])]
                //    #[Groups('hike:read')]
                //    private $hikeImages;
                $entityManager->persist($img);
            }
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
    public function edit(Request $request, Hike $hike, HikeRepository $hikeRepository, EntityManagerInterface $entityManager, SluggerInterface $slugger, Telechargement $telechargement): Response
    {
        $form = $this->createForm(HikeType::class, $hike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $hikeRepository->add($hike);
            // gestion des images (on récupère les images transmises)
            // dans la variables nous allons récupérer dans le form sous la propriétée 'images' les datas
            $images = $form->get('images')->getData();
            if($images) {
                // Une boucle sera nécessaire sur les images (afin de gérer l'ajout multiple)
//               foreach ($images as $image){
                // On stocke le nom de l'image dans la BDD (pour rappel nous ne stockons pas de PJ en BDD)
                // instance de UploadImages
                $img = new HikeImages();
                // On attribut un nom qui sera alors inscrit en BDD (nous utilisons la variable $fichier cf plus haut)
                //puis on upload l'image avec la method créé
                $hikeImageFileName = $telechargement->uploadImg($images);
                $img->setName($hikeImageFileName);
                $hike->addHikeImage($img);
                //On persist la donnée (autre solution la cascade en 'persist' sur l'entity :
                // //    #[ORM\OneToMany(mappedBy: 'hike', targetEntity: HikeImages::class, orphanRemoval: true, cascade: ["persist"])]
                //    #[Groups('hike:read')]
                //    private $hikeImages;
                $entityManager->persist($img);
            }

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
