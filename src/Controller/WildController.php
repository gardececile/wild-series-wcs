<?php
//src/controller/WildController.php

namespace App\Controller;

//use Psr\Container\ContainerInterface;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Season;
use App\Form\ProgramSearchType;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
/**
 * @Route("/wild", name="wild_")
 */

class WildController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index() : Response
    {
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findAll();

        if (!$programs){
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
//        return $this->render('wild/index.html.twig',
//            ['programs' => $programs]
//            );

        $form = $this->createForm(
            ProgramSearchType::class,
            null,
            ['method'=> Request::METHOD_GET]
        );
        return $this->render('wild/index.html.twig',[
            'programs' =>$programs,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Getting a program with the id of a program quest 10
     *
     * @param int $id
     * @Route("/show/{id}", name="show")
     */
    public function show(program $program): Response
    {
        return $this->render('wild/program.html.twig', ['program' => $program ]);
    }

    /**
     * Getting a program to show by category depending of the findBy(our category name)
     * @Route("/category/{categoryName}", name="show_category")
     */
    public function showByCategory(string $categoryName): Response
    {
        if (!$categoryName) {
            throw $this
            ->createNotFoundException('No name of category found');
        }

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name'=> $categoryName]);

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category'=> $category], ['id' => 'DESC'] , 3);

        return $this->render('wild/category.html.twig', [
            'programs' => $program,
    ]);
    }

    /**
     * Getting a program to show depending of a formatted slug for title
     * la méthode showByProgram() récupère un programme à partir d'un slug passé dans l'url
     *
     * @param string $slug The slugger
     * @Route("/program/{slug}", defaults={"slug" =null}, name="show_program")
     */
    public function showByProgram(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title'=> mb_strtolower($slug)]);

        $seasons= $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program'=>$program]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with' .$slug.'title, found in program\'s table.'
            );
        }

        return $this->render('wild/program.html.twig', [
            'program' => $program,
            'slug' => $slug,
            'seasons' =>$seasons,
        ]);
    }

    /**
     * Getting a program to show all the progroms depending of the id of the program (id meaning the year of season: e.g. id=1 for season1)
     * la méthode showBySeason() prend en compte en paramètre l'id de la saison (issu de l'url) et récupère la saison corresponsdante
     *
     * @param integer $id
     * @Route("/program/season/{id}", name="show_season")
     */
    public function showBySeason(int $id):Response
    {
        if (!$id) {
            throw $this
                ->createNotFoundException('No id has been sent to find the programs of the season.');
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($id);

        $program = $season->getProgram();

        $episodes = $season->getEpisodes();

        if (!$season) {
            throw $this->createNotFoundException(
                'No program with found in program\'s table.'
            );
        }

        return $this->render('wild/season.html.twig', [
            'season' => $season,
            'program'=> $program,
            'episodes' => $episodes,
        ]);

    }
    /**
     * @param integer $id
     * @Route("/episode/{id}", name="show_episode")
     */
    public function showEpisode(episode $episode):response
    {
        $season =  $episode->getSeason();
        $program = $season->getProgram();
        return $this->render('wild/episode.html.twig', [
            'episode'=> $episode,
            'program'=> $program,
            'season'=> $season,
        ]);
    }


}