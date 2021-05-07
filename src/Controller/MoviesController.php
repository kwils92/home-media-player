<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\MoviesType;
use App\Repository\MoviesRepository;
use App\Service\UtilController;
use App\Form\BatchMovieInsertType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/movie_batch", name="new_movie_batch", methods={"GET", "POST"}))
     */
    public function bulkMovieInsertFromFile(Request $request, UtilController $util) : Response
    {
        $form = $this->createForm(BatchMovieInsertType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $contents = file($data['file']);
            
            foreach($contents as $record){
                $Movie = new Movies(); 

                $Movie
                    ->setTitle($util->formatMediaTitle($record))
                    ->setFilepath($util->formatMediaFilePath('Movies', 'video_sym', '', '', $record))
                    ->setRating(0)
                    ->setCategory(null)
                    ->setFormat($util->determineFileTypeFromFile('Movies', $record))
                    ->setSortingField(
                        $util->spliceArticleForSorting(
                            $util->formatMediaTitle($record)
                        )
                    );
                $entityManager->persist($Movie);
            }

            $entityManager->flush(); 
            
            return $this->redirectToRoute('movies_index');
        }

        return $this->render('static_pages/batch_insert.html.twig', [ 
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movies_show", methods={"GET"})
     */
    public function show(Movies $movie): Response
    {
        $movieDetails = $movie->getMovieDetails();
        
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
