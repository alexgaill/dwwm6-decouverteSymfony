<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/category', name: 'category')]
    public function index(): Response
    {
        // $categories = [
            // ["title" => 'categorie n°1'],
            // ["title" => 'categorie n°2'],
            // ["title" => 'categorie n°3'],
            // ["title" => 'categorie n°4']
        // ];
        // $categories = null;

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('category/index.html.twig', [
            'categoriesList' => $categories,
        ]);
    }

    /**
     * @Route("/category/single/{categorie}", name="singleCategorie")
     *
     * @return Response
     */
    public function single (Categorie $categorie): Response
    {
        return $this->render("category/single.html.twig", [
            "categorie" => $categorie
        ]);
    }

    /**
     * @Route("/category/create", name="createCategory")
     */
    public function create (Request $request): Response
    {
        $category = new Categorie();
        // $categorie->setTitle("categorie n°x");

        $form = $this->createFormBuilder($category)
                ->add("title", TextType::class, [
                    "label" => "Titre de la catégorie",
                    "attr" => ["class" => "form-control"]
                ])
                ->add("save", SubmitType::class)
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute("category");
        }

        return $this->render("category/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
