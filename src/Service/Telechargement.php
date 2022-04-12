<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class Telechargement
{
    private $container;
    private $slugger;

    public function __construct(ContainerInterface $container, SluggerInterface $slugger)
    {
        $this->container = $container;
        $this->slugger = $slugger;
    }

    public function uploadImg(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try {
            // On copie ensuite le fichier dans le dossier upload, l'ordre des paramètres et OU, puis QUOI
            //on récupére le paramétre indiquant le chemin ou trouver le dossier upload (cf services.yaml)
            $file->move($this->getTargetDirectory()->getParameter('upload_directory'), $fileName);
        } catch (FileException $e) {
            // ... prise en charge des expeptions si un event se produit durant l'upload du fichier
            return null; // ici le retour sera null pour le moment
        }
        return $fileName;
    }
    public function getTargetDirectory()
    {
        return $this->container;
    }
}