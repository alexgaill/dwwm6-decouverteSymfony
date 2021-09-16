<?php

namespace App\Controller;

use App\Entity\Categorie;
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
        // $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreatedAt(new \DateTime());

            // $post->setCategory($this->getDoctrine()->getRepository(Categorie::class)->find(3));

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute("singlePost", ["post" => $post->getId()]);
        }

        return $this->render("post/create.html.twig", [
            "form" => $form->createView()
            // "categories" => $categories
        ]);
    }

    /**
     * @Route("/post/{post}/update", name="updatePost")
     *
     * @return Response
     */
    public function update(Post $post, Request $request): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute("singlePost", ["post" => $post->getId()]);
        }

        return $this->render("post/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/post/{post}/delete", name="deletePost")
     */
    public function delete(Post $post) :Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute("post");
    }

}
