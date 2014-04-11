<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UrlReducer\CoreBundle\Entity\Url;

class DefaultController extends Controller {
    public function indexAction($name) {
    	$oManager = $this->getDoctrine()->getManager();

    	$oUrl = new URLS;

        return $this->render('UrlReducerCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
