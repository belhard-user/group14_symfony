<?php

namespace App\Controller;

use App\Service\Quotes;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TestController extends Controller
{
    private $log;

    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    /**
     * @Route("/test", name="test")
     */
    public function index(Environment $twigEnvironment, Quotes $quotes)
    {
        $q = $quotes->getQuotes();
        $html = $twigEnvironment->render('test/index.html.twig', [
            'q' => $q
        ]);

        return new Response($html);
        // return $this->render('test/index.html.twig', []);
    }
}
