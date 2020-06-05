<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;

/**
 * @Route("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @
     */
    public function index(Request $request) : Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

             return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
public function add(Request $request) : Response
{
    $category = new Category();

    $form = $this->createForm(
        CategoryType::class,
        $category);

    $form -> handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()){
        $data = $form->getData();
        $newcategory = $this->getDoctrine()->getManager();
        $newcategory->persist($data);
        $newcategory->flush();
        return $this->redirectToRoute('category_index');
    }
    return $this->render('category/add.html.twig',[
            'form'=> $form->createView(),
        ]
    );
}

}
