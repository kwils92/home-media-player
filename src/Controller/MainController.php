<?php

namespace App\Controller;

use App\Repository\ShowsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

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
     * @Route("/admin_page", name="admin_page")
     */
    public function admin()
    {
        return $this->render('static_pages/admin_landing.html.twig');
    }
}
