<?php

namespace App\Controller;

use App\Entity\Test;
use App\Service\Quotes;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


// https://stackoverflow.com/questions/48230652/symfony-4-fixtures-with-nelmio-alice-not-persisting fixtures 

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

    /**
     * @Route("/add-to-database", name="add_data")
     */
    public function addToDataBase(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $test = new Test();
        $test
            ->setName('Neo')
            ->setIp($request->getClientIp())
        ;
        $em->persist($test);

        $test2 = new Test();
        $test2
            ->setName('Neo 2')
            ->setIp($request->getClientIp())
        ;
        $em->persist($test2);

        // $em->flush();
        
        return $this->render('test/add-to-data-base.html.twig');
    }

    /**
     * @Route("/show-test-data", name="show_test_data")
     */
    public function showTestTable()
    {
        $allTestRecord = $this->getDoctrine()
            ->getRepository(Test::class)
            // ->findUserWhoseIdIsMoreThanTwo()
            ->findAll()
        ;
        // dump($allTestRecord); die;

        return $this->render('test/show-test-data.html.twig', [
            'allTestRecord' => $allTestRecord
        ]);
    }
}
