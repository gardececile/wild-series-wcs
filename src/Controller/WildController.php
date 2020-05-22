<?php
//src/controller/WildController.php

namespace App\Controller;

//use Psr\Container\ContainerInterface;
use App\Entity\Category;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('wild/index.html.twig',
            ['programs' => $programs]
            );
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" =null}, name="show")
     *
     */
    public function show (?string $slug): Response
    {
        if (!$slug) {
            throw $this
            ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title'=> mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with' .$slug.'title, found in program\'s table.'
            );
        }

         return $this->render('wild/show.html.twig', [
             'program' => $program,
             'slug' => $slug,
         ]);
    }

    /**
     * Getting a program to show by category depending of the findBy(our category name)
     * @Route("/category/{categoryName}", name="show_category")
     *
     **/
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
     * @Route("/program/{slug<^[a-z0-9-]+$>}", defaults={"slug" =null}, name="show_program")
     *
     **/
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

}