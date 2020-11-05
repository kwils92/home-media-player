<?php

namespace App\Controller;

use App\Repository\ShowsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('static_pages/main.html.twig', [

        ]);
    }

    /**
     * @Route("/shows2", name="shows_all")
     */
    public function allShows(ShowsRepository $showRepo)
    {
        return $this->render('shows/index.html.twig', [
            'shows' => $showRepo->findAll(),
        ]);
    }

    /**
     * @Route("/shows2/{show_id}", name="shows_one")
     */
    public function showById($showId)
    {
        return $this->render('main/main.html.twig', [

        ]);
    }

    /**
     * @Route("/shows2/{showid}/{episodeid}", name="episodes_one")
     */
    public function episodeById()
    {
        return $this->render('main/main.html.twig', [

        ]);
    }
}
