<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', []);
    }

    /**
     * @Route("/blog/{slug}", name="article", requirements={"slug":"\w+"})
     * @Method({"PUT", "POST", "GET"})
     */
    public function test($slug)
    {
        $res = new Response('<html><body><h1>'.$slug.'</h1></body></html>');
        $res->headers->set('Foo', 'foobar');

        return $res;
    }
}