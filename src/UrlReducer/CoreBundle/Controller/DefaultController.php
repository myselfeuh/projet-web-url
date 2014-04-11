<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\Membre;

class DefaultController extends Controller {
    public function phpinfoAction() {
        echo phpinfo();
    }

    public function indexAction($name) {
    	$oDoctrine = $this->getDoctrine();
    	$oManager = $oDoctrine->getManager();

    	$oMembre = new Membre;
    	$oMembre->setNom('Penaud')
    		 	->setPrenom('Guillaume')
    		 	->setPseudo('sephres')
    		 	->setMail('guillaume.penaud@gmail.com')
    		 	->setMdp('azerty')
    		 	->setActivation('ok')
    		 	->setProfil('admin');

    	$oManager->persist($oMembre);

    	$oMembreRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Membre');
    	$oMembreRepository->findOneByPseudo('sephres');	

    	$oUrl_1 = new Url;
    	$oUrl_1->setSource('http://fr.google.com')
    		   ->setCourte('http://bit.ly.xHt6D')
    		   ->setAuteur($oMembre);

    	$oManager->persist($oUrl_1);

    	$oUrl_2 = new Url;
    	$oUrl_2->setSource('http://fr.itworks.com')
    		   ->setCourte('hey')
    		   ->setAuteur($oMembre);

    	$oManager->persist($oUrl_2);

    	$oManager->flush();

        return $this->render('UrlReducerCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
