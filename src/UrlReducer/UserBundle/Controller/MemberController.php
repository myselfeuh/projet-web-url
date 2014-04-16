<?php

namespace UrlReducer\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\User;
use UrlReducer\UserBundle\Service\Authentifier;
use UrlReducer\CoreBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class MemberControllerException extends \Exception {};

/**
 *
 */
class MemberController extends AbstractUserController {
	/**
     *
     */
    public function modifyAction(Request $oRequest) {
    	$oAuthentifier = $this->container->get('url_reducer_user.authentifier');

    	try {
    		if ($oAuthentifier->getStatus() == Authentifier::IS_VISITOR) {
    			throw new UserControllerException;
    		}

    		$oUser = $oAuthentifier->getUser();

    		// handle form
		    $oFormRegister = $this->createForm(new UserType, $oUser);
		    $oFormRegister->handleRequest($oRequest);

		    if ($oFormRegister->isValid()) {
                // retrieve form data as a User object
                $oUser = $oFormRegister->getData();

                // persist 
                $this->processUserForm($oUser);

                // set the user in session, and redirect to index page
                $sRedirectUrl = $this->generateUrl('url_reducer_user_modify');
                $oResponse = $this->redirect($sRedirectUrl);
		    } else {
		    	// construct form view
                $oResponse = $this->render(
                    'UrlReducerCoreBundle:User:register.user.html.twig',
                    array('form_register_user' => $oFormRegister->createView())
                );
		    }
    	} catch (UserControllerException $e) {
    		// get some services
		    $oFlashBag = $this->get('session')->getFlashBag();
		    $oFlashBag->add('user message', "Vous n'avez pas les droits d'accès");

    		$sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
    		$oResponse = $this->redirect($sUrlToIndex);
    	}

        return $oResponse;
    }

    /**
     *
     */
    public function logoutAction() {
    	$oSession = $this->get('session');
    	$oFlashBag = $oSession->getFlashBag();

    	$oAuthentifier = $this->container->get('url_reducer_user.authentifier');

    	// check that there is a user connected
    	if ($oAuthentifier->isVisitor()) {
    	// add a error message through flashbag
    		$oFlashBag->add('user_flash', 'Aucun membre connecté');
    	} else {
    	// remove user_id from session
    		$oSession->clear();
    	}

    	$sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
	    
	    return $this->redirect($sUrlToIndex);
    }
}
