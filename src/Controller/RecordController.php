<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Producer;
use App\Entity\Record;
use App\Repository\ArtistRepository;
use App\Repository\ProducerRepository;
use App\Repository\RecordRepository;
use http\Env\Response;
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

    /**
     * Page d'un artiste
     * @Route("/artist/{id}", name="artist_page")
     */
    public function artistPage(Artist $artist)
    {
        return $this->render('record/artist_page.html.twig', [
            'artist' => $artist
        ]);
    }

    /**
     * Page d'un album
     * @Route("/record/{id}", name="record_page")
     */
    public function recordPage(Record $record)
    {
        return $this->render('record/record_page.html.twig', [
            'record' => $record
        ]);
    }

    /**
     * Page d'un album
     * @Route("/news", name="record_news")
     */
    public function newRecord(RecordRepository $recordRepository)
    {
        return $this->render('record/record_news.html.twig', [
            'record_news' => $recordRepository->findNewRecords(),
        ]);
    }

    /**
     * Page d'un label de production
     * @Route("/label/{id}", name="label_page")
     */
    public function labelPage(RecordRepository $recordRepository, Producer $producer)
    {
        return $this->render('record/label_page.html.twig', [
//            'label_records' => $recordRepository->findRecordsFromProducer($producer->getId()),
            'label_records' => $recordRepository->findBy(['producer' => $producer->getId()]),
            'label_name' => $producer->getName(),
        ]);

    }
}
