<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     *
     * @return Response
     */
    // #[Route('/post', name: 'post')]
    public function index(): Response
    {
        $articles = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->render('post/index.html.twig', [
            'listArticles' => $articles,
        ]);
    }

    /**
     * @Route("/post/single/{post}", name="singlePost")
     *
     */
    public function single(Post $post) :Response
    {
        // $article = $this->getDoctrine()->getRepository(Post::class)->find($id);
        dump($post);
        return $this->render("post/single.html.twig", [
            "article" => $post
        ]);
    }
}
