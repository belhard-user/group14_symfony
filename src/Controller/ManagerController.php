<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ManagerController extends Controller
{
    /**
     * @Route("/manager/article-list", name="manager_article_list")
     */
    public function listOfArticle()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        
        return $this->render('manager/article-list.html.twig', [
            'articles' => $articles
        ]);
    }
}
