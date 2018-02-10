<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index()
    {
        return new Response('<html><body><h1>Hello world</h1></body></html>');
    }

    public function test()
    {
        $res = new Response('<html><body><h1>abra</h1></body></html>');
        $res->headers->set('Foo', 'foobar');

        return $res;
    }
}