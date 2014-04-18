<?php

namespace UrlReducer\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Form\UserType;

use UrlReducer\UserBundle\Entity\User;
use UrlReducer\UserBundle\Service\Authentifier;

class UserControllerException extends \Exception {};

/**
 *
 */
class UserController extends AbstractUserController {
	/**
     * 
     */
    public function loginAction(Request $oRequest) {
    	$oResponse = null;
    	$bLoginIsValidated = false;

		$oFormBuilder = $this->createFormBuilder()
		                     ->add('pseudo', 'text')
		                     ->add('password', 'password')
		                     ->add("s'authentifier", 'submit');

		$oFormLogin = $oFormBuilder->getForm();

		$oSession = $this->get('session');
	    $oFlashBag = $oSession->getFlashBag();

	    $oFormLogin->handleRequest($oRequest);

	    if ($oFormLogin->isValid()) {
	    	$oFormLoginData = $oFormLogin->getData();

	    	$sPseudo 	 = $oFormLoginData['pseudo'];
	    	$sPassword 	 = $oFormLoginData['password'];

	   		$oUserRepository = $this->getDoctrine()->getRepository('UrlReducerUserBundle:User');
        	$oUser 		   = $oUserRepository->findOneByPseudo($sPseudo);

        	$sCryptedPassword = crypt($sPassword, 'user');

        	if ($oUser == null) {
        		$oFlashBag->add('user_flash', 'No user found');
        	} else if ($oUser->getMdp() != $sCryptedPassword) {
        		$oFlashBag->add('user_flash', 'Wrong password');
        	} else {
        		$oSession->set('user_id', $oUser->getId());
        		$bLoginIsValidated = true;
        	}
	    }

	    if ($bLoginIsValidated) {
	    	$sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
	    	$oResponse = $this->redirect($sUrlToIndex);
	    } else {
			$aRenderingData = array(
				'form_login_user' => $oFormLogin->createView()
			);

			$oResponse = $this->render(
	            'UrlReducerUserBundle:User:login.user.html.twig',
	            $aRenderingData
        	);
	    }

    	return $oResponse;
    }

    /**
     * 
     */
    public function registerAction(Request $oRequest) {
	    try {
	    	// initialization
	    	$oUser = new User;

	    	// get some services
		    $oFlashBag = $this->get('session')->getFlashBag();

		    // handle form
		    $oFormRegister = $this->createForm(new UserType, $oUser);
		    $oFormRegister->handleRequest($oRequest);

		    if (!$oFormRegister->isValid()) {
		    	throw new UserControllerException('Form has not yet been submitted');
		    } else {
		    	// retrieve form data as a User object
		    	$oUser = $oFormRegister->getData();
		    	$oUserRepository = $this->getDoctrine()->getRepository('UrlReducerUserBundle:User');

		    	// check: if the user who's registering is the first of the application, he must be an administrator
		    	if ($oUserRepository->count() == 0) {
		    		// set some values (NOTE: force activation for the moment)
		    		$oUser->setProfil('admin');
		    	} else {
		    		// set some values (NOTE: force activation for the moment)
		    		$oUser->setProfil('user');
		    	}

		    	// persist 
		    	$this->processUserForm($oUser);

	            // set the user in session, and redirect to index page
	            $this->get('session')->set('user_id', $oUser->getId());
	            $sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
	            $oResponse = $this->redirect($sUrlToIndex);
		    }
	    } catch (UserControllerException $e) {
	    	// construct form view
			$aRenderingData = array(
				'form_register_user' => $oFormRegister->createView()
			);

	    	$oResponse = $this->render(
	            'UrlReducerUserBundle:User:register.user.html.twig',
	            $aRenderingData
	        );
	    }

        return $oResponse;
    }
}
