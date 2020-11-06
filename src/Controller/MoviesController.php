<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\MoviesType;
use App\Repository\MoviesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movies")
 */
class MoviesController extends AbstractController
{
    /**
     * @Route("/", name="movies_index", methods={"GET"})
     */
    public function index(MoviesRepository $moviesRepository): Response
    {
        return $this->render('movies/index.html.twig', [
            'movies' => $moviesRepository->findAllSorted('ASC'),
        ]);
    }

    /**
     * @Route("/new", name="movies_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $movie = new Movies();
        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('movies_index');
        }

        return $this->render('movies/new.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movies_show", methods={"GET"})
     */
    public function show(Movies $movie): Response
    {
        $movieDetails = $movie->getMovieDetails();
        //$movieDetails = array("Year" => "2014", "Director" => "Wes Bays, Quentin Tarantino, M. Night Shyamalan, Davey Jones, Lockheed Martin ", "Title" => "Maze Runner", "Plot" => "The guy goes to the store and it's like, cold, but not too cold, so he didn't bring a jacket. Then--snows. Straight up. No seriously. It does, dude seriously. Then he gets way too cold, so on the way home its just awful. For like 15 minutes--walking--his face is cold, and his nose hurts, and he didn't even bring boots so the icy water is soaking into his socks. At least when he gets home, however, its nice and warm though.", "Rated" => "PG-13", "Genre" => "Romance, Crime, Drama");

        return $this->render('movies/show.html.twig', [
            'movie' => $movie,
            'movie_details' => $movieDetails, 
        ]);
    }

    /**
     * @Route("/{id}/edit", name="movies_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Movies $movie): Response
    {
        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movies_index');
        }

        return $this->render('movies/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movies_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Movies $movie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('movies_index');
    }

    /**
     * @Route("/{id}/rate", name="movies_rate", methods={"GET","POST"})
     */
    public function rate(Request $request, Movies $movie): Response
    {
        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('movies_show', ['id' => $movie->getId()]);
        }

        return $this->render('movies/rate.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }
}
