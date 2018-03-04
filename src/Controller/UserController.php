<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/list-of-users", name="user_list")
     */
    public function list()
    {
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }
}
