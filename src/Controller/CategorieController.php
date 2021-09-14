<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
