<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\User;
use UrlReducer\CoreBundle\Service\Authentifier;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {
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

	   		$oUserRepository = $this->getDoctrine()->getRepository('UrlReducerCoreBundle:User');
        	$oUser 		   = $oUserRepository->findOneByPseudo($sPseudo);

        	$sCryptedPassword = crypt($sPassword, 'user_salt');

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
	            'UrlReducerCoreBundle:User:login.user.html.twig',
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

			$oFormBuilder = $this->createFormBuilder($oUser)
			                     ->add('nom', 'text')
			                     ->add('prenom', 'text')
			                     ->add('pseudo', 'text')
			                     ->add('mail', 'text')
			                     ->add('mdp', 'password')
			                     ->add('profil', 'choice', 
			                     	array('choices' => 
			                     		array(
			                     			'user' => 'Membre', 
			                     			'admin'  => 'Administrateur'
			                     		)
									))
			                     ->add("s'inscrire", 'submit');

			// handle form
			$oFormRegister = $oFormBuilder->getForm();
		    $oFormRegister->handleRequest($oRequest);

		    if (!$oFormRegister->isValid()) {
		    	throw new UserControllerException('Form has not yet been submitted');
		    } else {
		    	// retrieve form data as a User object
		    	$oUser = $oFormRegister->getData();

		    	// crypt user's password
		    	$sPassword 	 = $oUser->getMdp();
	        	$sCryptedPassword = crypt($sPassword, $oUser->getId());

	        	// get some services
	        	$oDoctrine = $this->getDoctrine();
	            $oManager = $oDoctrine->getManager();

	            $oUserRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:User');

	            // check: if the user who's registering is the first of the application, he must be an administrator
	            if ($oUserRepository->count() == 0 && $oUser->getProfil() != 'admin') {
	            	$sError = 'Le premier membre inscrit du site doit absolument être un administrateur';

	            	$oFlashBag->add('user_flash', $sError);
	            	// switch save process
	            	throw new UserControllerException($sError);
	            }

	            // set some values (NOTE: force activation for the moment)
	            $oUser->setMdp($sCryptedPassword);
	            $oUser->setActivation('ok');

	            $oManager->persist($oUser);
	            $oManager->flush(); 

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
	            'UrlReducerCoreBundle:User:register.user.html.twig',
	            $aRenderingData
	        );
	    }

        return $oResponse;
    }

    /**
     *
     */
    public function modifyAction(Request $oRequest) {

    }

    /**
     *
     */
    public function logoutAction() {
    	$oSession = $this->get('session');
    	$oFlashBag = $oSession->getFlashBag();

    	$oAuthentifier = $this->container->get('url_reducer_core.authentifier');

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

class UserControllerException extends \Exception {};
