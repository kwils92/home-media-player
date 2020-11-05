<?php

namespace App\Controller;

use App\Entity\ShowEpisodes;
use App\Entity\Shows;
use App\Form\ShowEpisodesType;
use App\Repository\ShowEpisodesRepository;
use App\Repository\ShowsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shows/episodes")
 */
class ShowEpisodesController extends AbstractController
{
    /**
     * @Route("/", name="show_episodes_index", methods={"GET"})
     */
    public function index(ShowEpisodesRepository $showEpisodesRepository, ShowsRepository $showsRepository): Response
    {   
        return $this->render('show_episodes/index.html.twig', [
            'show_episodes' => $showEpisodesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="show_episodes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $showEpisode = new ShowEpisodes();
        $form = $this->createForm(ShowEpisodesType::class, $showEpisode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($showEpisode);
            $entityManager->flush();

            return $this->redirectToRoute('show_episodes_index');
        }

        return $this->render('show_episodes/new.html.twig', [
            'show_episode' => $showEpisode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_episodes_show", methods={"GET"})
     */
    public function show(ShowEpisodes $showEpisode, ShowsRepository $showsRepository): Response
    {
        $show = $showsRepository->findBy(['id' => $showEpisode->getShowTitle()->getId()]);
        
        return $this->render('show_episodes/show.html.twig', [
            'show_episode' => $showEpisode,
            'show' => $show,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="show_episodes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ShowEpisodes $showEpisode): Response
    {
        $form = $this->createForm(ShowEpisodesType::class, $showEpisode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_episodes_index');
        }

        return $this->render('show_episodes/edit.html.twig', [
            'show_episode' => $showEpisode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_episodes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ShowEpisodes $showEpisode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$showEpisode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($showEpisode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_episodes_index');
    }

    /**
     * @Route("/{id}/rate", name="show_episodes_rate", methods={"GET","POST"})
     */
    public function rate(Request $request, ShowEpisodes $showEpisode): Response
    {
        $form = $this->createForm(ShowEpisodesType::class, $showEpisode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('show_episodes_show', ['id' => $showEpisode->getId()]);
        }

        return $this->render('show_episodes/rate.html.twig', [
            'show_episode' => $showEpisode,
            'form' => $form->createView(),
        ]);
    }
}
