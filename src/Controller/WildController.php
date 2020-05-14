<?php
//src/controller/WildController.php

namespace App\Controller;

//use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/wild", name="wild_")
 */

class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index() : Response
    {
        return $this->render('/index.html.twig',
            ['website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/show/{slug}",
     *     requirements={"slug"="[a-z0-9\-]+"},
     *     defaults={"slug"="Aucune série sélectionnée, veuillez choisir une série"},
     *     name="show"
     * )
     */
    public function show ($slug): Response
    {
        //remplacer tous les tirets du slug par des espaces
        $adaptedSlug=str_replace('-',' ',$slug);
            // puis passer la première lettre de chaque mot en MAJUSCULE
        $UpAdaptedSlug=ucwords($adaptedSlug);
        return $this->render('wild/show.html.twig',
            ['slug'=>$UpAdaptedSlug]);
    }

}