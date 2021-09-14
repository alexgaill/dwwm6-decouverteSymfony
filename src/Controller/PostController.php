<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
        dump($post);
        return $this->render("post/single.html.twig", [
            "article" => $post
        ]);
    }

    /**
     * @Route("/post/create", name="createPost")
     */
    public function create (Request $request): Response
    {
        $post = new Post();
        $form= $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreatedAt(new \DateTime());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute("singlePost", ["post" => $post->getId()]);
        }

        return $this->render("post/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

}
