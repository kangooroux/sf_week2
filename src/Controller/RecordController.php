<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecordController extends AbstractController
{
    /**
     * @Route("/artist", name="artist_list")
     */
    public function index(ArtistRepository $artistRepository)
    {
        return $this->render('record/artist_list.html.twig', [
            'artist_list' => $artistRepository->findAll(),
        ]);
    }
}
