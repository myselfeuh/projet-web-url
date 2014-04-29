<?php

namespace UrlReducer\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\UserBundle\Entity\User;
use UrlReducer\UserBundle\Service\Authentifier;
use UrlReducer\CoreBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class AbstractUserControllerException extends \Exception {};

/**
 *
 */
class AbstractUserController extends Controller {
	/**
	 *
	 */
	public function renderAccessLevelException() {
		// get some services
	    $oFlashBag = $this->get('session')->getFlashBag();
	    $oFlashBag->add('error', "Vous n'avez pas les droits d'accès");

		$sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
		return $this->redirect($sUrlToIndex);
	}

	/**
	 *
	 */
	public function processUserForm($oFormObject) {
		// crypt user's password
		$sPassword 	 = $oFormObject->getMdp();
		$sCryptedPassword = crypt($sPassword, 'user');

		// get some services
		$oDoctrine = $this->getDoctrine();
	    $oManager = $oDoctrine->getManager();

	    // set some values (NOTE: force activation for the moment)
	    $oFormObject->setMdp($sCryptedPassword);
	    $oFormObject->setActivation('ok');

	    $oManager->persist($oFormObject);
	    $oManager->flush(); 
	}
}