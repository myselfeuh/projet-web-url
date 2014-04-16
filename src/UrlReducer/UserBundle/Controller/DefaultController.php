<?php

namespace UrlReducer\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UrlReducerUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
