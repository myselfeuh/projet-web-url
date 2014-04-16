<?php

namespace UrlReducer\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\UserBundle\Entity\User;
use UrlReducer\CoreBundle\Service\Authentifier;
use UrlReducer\CoreBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class AdminControllerException extends \Exception {};

/**
 *
 */
class AdminController extends AbstractUserController {
	/**
	 *
	 */
	public function manageAction() {
		$oAuthentifier = $this->container->get('url_reducer_user.authentifier');

    	try {
    		if ($oAuthentifier->getStatus() != Authentifier::IS_ADMIN) {
    			throw new AdminControllerException;
    		}

    		$oUser = $oAuthentifier->getUser();

    		// handle form
		    $oFormRegister = $this->createForm(new UserType, $oUser);
		    $oFormRegister->handleRequest($oRequest);

		    if ($oFormRegister->isValid()) {
                
		    } else {
		    	// construct form view
                $oResponse = $this->render(
                    'UrlReducerCoreBundle:User:register.user.html.twig',
                    array('form_register_user' => $oFormRegister->createView())
                );
		    }
    	} catch (AdminControllerException $e) {
    		$oResponse = $this->renderAccessLevelException();
    	}

        return $oResponse;
	}
}
