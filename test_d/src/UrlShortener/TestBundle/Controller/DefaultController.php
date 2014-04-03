<?php

namespace UrlShortener\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	/**
	 *
	 */
    public function indexAction($name) {
        return $this->render('UrlShortenerTestBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     *
     */
    public function testAction($nom_test) {
        return $this->render('UrlShortenerTestBundle:Default:test.html.twig', array('nom_test' => $nom_test));
    }
}
