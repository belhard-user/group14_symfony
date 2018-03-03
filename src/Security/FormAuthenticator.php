<?php

namespace App\Security;


use App\Entity\User;
use App\Form\AuthType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class FormAuthenticator extends AbstractFormLoginAuthenticator
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        RouterInterface $router,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return $request->getPathInfo() == '/login' && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(AuthType::class);
        $form->handleRequest($request);
        $data = $form->getData();

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->em->getRepository(User::class)->findOneBy([
            'email' => $credentials['_username']
        ]);

        if(! $user){
            throw new AuthenticationException('User not found');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $passowrd = $credentials['_password'];

        return $this->passwordEncoder->isPasswordValid($user, $passowrd);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('article_index');

        return new RedirectResponse($url);
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }


}