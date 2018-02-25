<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/blog")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/", name="article_index")
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAllArticle()
        ;

        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/create", name="article_create")
     */
    public function create(Request $request)
    {
        $articleForm = $this->createForm(ArticleType::class);
        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $articleData = $articleForm->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($articleData);
            $em->flush();

            $this->addFlash('success', 'Статья создана');

            return $this->redirectToRoute('article_index');
        }



        return $this->render('article/create.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="article_edit")
     * @Method({"GET", "PUT"})
     */
    public function edit(Request $request, Article $article)
    {
        $articleForm = $this->createForm(ArticleType::class, $article, [
            'method' => 'PUT'
        ]);
        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $articleData = $articleForm->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($articleData);
            $em->flush();

            $this->addFlash('success', 'Статья обнавлена');

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
    }

    /**
     * @Route("/{slug}/show", name="article_show")
     */
    public function show(Article $article)
    {
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/{id}/delete", name="article_delete")
     * @Method({"DELETE"})
     */
    public function delete(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return new Response(null, 204);
    }
}
