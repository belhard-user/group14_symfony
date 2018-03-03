<?php

namespace App\Controller;

use App\Form\AuthType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        $form = $this->createForm(AuthType::class, [
            '_username' => $lastUsername
        ]);

        return $this->render('security/index.html.twig', array(
            'form'  => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('oO');
    }
}
