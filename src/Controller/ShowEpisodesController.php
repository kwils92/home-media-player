<?php

namespace App\Controller;

use App\Service\UtilController;
use App\Entity\ShowEpisodes;
use App\Form\BatchInsertType;
use App\Form\ShowEpisodesType;
use App\Repository\ShowsRepository;
use App\Repository\ShowEpisodesRepository;
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
    public function index(ShowEpisodesRepository $showEpisodesRepository): Response
    {   
        return $this->render('show_episodes/index.html.twig', [
            'show_episodes' => $showEpisodesRepository->findAllSorted('ASC'),
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
     * @Route("/new_batch", name="new_batch", methods={"GET", "POST"}))
     */
    public function getFileNamesFromFile(Request $request, UtilController $util, ShowsRepository $sRepo) : Response
    {
        $form = $this->createForm(BatchInsertType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $contents = file($data['file']);
            
            foreach($contents as $record){
                $Episode = new ShowEpisodes(); 

                $Episode
                    ->setTitle($util->formatMediaTitle($record)) 
                    ->setFilepath($util->formatMediaFilePath('Shows', 'video_sym', $data['season'], $sRepo->findOneBy(array('id' => $data['show'])), $record))
                    ->setRating(0)
                    ->setSeason($data['season'])
                    ->setShowTitle($sRepo->findOneBy(array('id' => $data['show'])))
                    ->setEpisode($util->determineEpisodeFromFile($record))
                    ->setCategory('S')
                    ->setFormat($util->determineFileTypeFromFile('Shows', $record));

                $entityManager->persist($Episode);
            }

            $entityManager->flush(); 
            
            return $this->redirectToRoute('show_episodes_index');
        }

        return $this->render('static_pages/batch_insert.html.twig', [ 
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_episodes_show", methods={"GET"})
     */
    public function show(ShowEpisodes $showEpisode, ShowEpisodesRepository $showEpisodesRepository): Response
    {
        $episodeDetails = $showEpisode->getEpisodeDetails();

        $prevEpisode = $showEpisodesRepository->findOneBy(
            array('episode'   => $showEpisode->getEpisode() - 1, 
                  'season'    => $showEpisode->getSeason(), 
                  'showTitle' => $showEpisode->getShowTitle()
            )
        );

        $nextEpisode = $showEpisodesRepository->findOneBy(
            array('episode'   => $showEpisode->getEpisode() + 1, 
                  'season'    => $showEpisode->getSeason(), 
                  'showTitle' => $showEpisode->getShowTitle()
            )
        );

        return $this->render('show_episodes/show.html.twig', [
            'show_episode' => $showEpisode,
            'next_episode' => $nextEpisode,
            'prev_episode' => $prevEpisode, 
            'episode_details' => $episodeDetails,
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
