<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Driver;
use App\Entity\Test;
use App\Form\TestType;
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
        
        $test = $this->getDoctrine()->getRepository(Test::class)->find(1);

        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();
        
        
        /*$em = $this->getDoctrine()->getManager();
        $test = new Test();
        $test
            ->setName('Neo')
            ->setIp($request->getClientIp())
            ->setCreatedAt(new \DateTime())
            ->setIsActive(true)
        ;
        $em->persist($test);

        $em->flush();*/
        
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
            ->findActiveUser()
        ;
        // dump($allTestRecord); die;

        return $this->render('test/show-test-data.html.twig', [
            'allTestRecord' => $allTestRecord
        ]);
    }

    /**
     * @Route("/test-form", name="add_test_data")
     */
    public function addTestRecord(Request $request)
    {
        $form = $this->createForm(TestType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $test = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();

            return $this->redirectToRoute('show_test_data');
        }
        
        return $this->render('test/test-from.html.twig', [
            'testForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/test/{id}/edit", name="test_edit")
     */
    public function editTestRecord(Test $test, Request $request)
    {
        $form = $this->createForm(TestType::class, $test);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $test = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();

            return $this->redirectToRoute('show_test_data');
        }

        return $this->render('test/edit-test-form.html.twig', [
            'testForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/test-db-relations")
     */
    public function testRelations()
    {
        $em = $this->getDoctrine()->getManager();

        $driver = new Driver();
        $driver->setName('Петя');
        $driver->setNumber(mt_rand(1000000, 9999999));

        $em->persist($driver);

        foreach(['mercedes', 'opel'] as $item){
            $car = new Car();
            $car->setMark($item);
            $car->setDriver($driver);

            $em->persist($car);
        }
        $em->flush();
        /*$driver = $this->getDoctrine()->getRepository('App:Driver')->find(1);
        $car = $this->getDoctrine()->getRepository('App:Car')->find(3);

        $car->setDriver($driver);
        $em->persist($car);

        $em->flush();*/

        return $this->render('test/relations.html.twig');
    }

    /**
     * @Route("/show-all-drivers")
     */
    public function showDrivers()
    {
        $drivers = $this->getDoctrine()->getRepository("App:Driver")->findAll();

        foreach($drivers as $driver){
            echo 'id: ' . $driver->getId() . 'Name: ' . $driver->getName() . '<br>';
            foreach ($driver->getCars() as $car){
                echo $car->getMark() . "<hr>";
            }
        }


        return $this->render('test/show-drivers.html.twig');
    }
}
