<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\Membre;
use UrlReducer\CoreBundle\Service\Authentifier;;

use Symfony\Component\HttpFoundation\Request;

class MemberController extends Controller {
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

	   		$oMemberRepository = $this->getDoctrine()->getRepository('UrlReducerCoreBundle:Membre');
        	$oMember 		   = $oMemberRepository->findOneByPseudo($sPseudo);

        	$sCryptedPassword = crypt($sPassword, 'user_salt');

        	if ($oMember == null) {
        		$oFlashBag->add('user_flash', 'No user found');
        	} else if ($oMember->getMdp() != $sCryptedPassword) {
        		$oFlashBag->add('user_flash', 'Wrong password');
        	} else {
        		$oSession->set('member_id', $oMember->getId());
        		$bLoginIsValidated = true;
        	}
	    }

	    if ($bLoginIsValidated) {
	    	$sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
	    	$oResponse = $this->redirect($sUrlToIndex);
	    } else {
			$aRenderingData = array(
				'form_login_member' => $oFormLogin->createView()
			);

			$oResponse = $this->render(
	            'UrlReducerCoreBundle:Member:login.member.html.twig',
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
	    	$oResponse = null;
	    	$oMember = new Membre;

	    	// get some services
	    	$oSession = $this->get('session');
		    $oFlashBag = $oSession->getFlashBag();

			$oFormBuilder = $this->createFormBuilder($oMember)
			                     ->add('nom', 'text')
			                     ->add('prenom', 'text')
			                     ->add('pseudo', 'text')
			                     ->add('mail', 'text')
			                     ->add('mdp', 'password')
			                     ->add('profil', 'choice', 
			                     	array('choices' => 
			                     		array(
			                     			'membre' => 'Membre', 
			                     			'admin'  => 'Administrateur'
			                     		)
									))
			                     ->add("s'inscrire", 'submit');

			// handle form
			$oFormRegister = $oFormBuilder->getForm();
		    $oFormRegister->handleRequest($oRequest);

		    if (!$oFormRegister->isValid()) {
		    	throw new MemberControllerException('Form has not yet been submitted');
		    } else {
		    	// retrieve form data as a Member object
		    	$oMember = $oFormRegister->getData();

		    	// crypt user's password
		    	$sPassword 	 = $oMember->getMdp();
	        	$sCryptedPassword = crypt($sPassword, 'user_salt');

	        	// get some services
	        	$oDoctrine = $this->getDoctrine();
	            $oManager = $oDoctrine->getManager();

	            $oMemberRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Membre');

	            // check: if the user who's registering is the first of the application, he must be an administrator
	            if ($oMemberRepository->count() == 0 && $oMember->getProfil() != 'admin') {
	            	$sError = 'Le premier membre inscrit du site doit absolument être un administrateur';

	            	$oFlashBag->add('user_flash', $sError);
	            	// switch save process
	            	throw new MemberControllerException($sError);
	            }

	            // set some values (NOTE: force activation for the moment)
	            $oMember->setMdp($sCryptedPassword);
	            $oMember->setActivation('ok');

	            $oManager->persist($oMember);
	            $oManager->flush(); 

	            // set the member in session, and redirect to index page
	            $this->get('session')->set('member_id', $oMember->getId());
	            $sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
	            $oResponse = $this->redirect($sUrlToIndex);
		    }
	    } catch (MemberControllerException $e) {
	    	// construct form view
			$aRenderingData = array(
				'form_register_member' => $oFormRegister->createView()
			);

	    	$oResponse = $this->render(
	            'UrlReducerCoreBundle:Member:register.member.html.twig',
	            $aRenderingData
	        );
	    }

        return $oResponse;
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
    	// remove member_id from session
    		$oSession->clear();
    	}

    	$sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
	    
	    return $this->redirect($sUrlToIndex);
    }

    /**
     *
     */
    public function menuAction($sRoute) {
    	$oAuthentifier = $this->container->get('url_reducer_core.authentifier');

    	$aUrls = array();

    	switch ($oAuthentifier->getStatus()) {
    		case Authentifier::IS_VISITOR:
    			$sMessage = 'Bienvenue';
    			
    			$aUrls['url_reducer_core_member_login'] 	= 'login';
    			$aUrls['url_reducer_core_member_register'] 	= 'inscription';
    			break;
    		case Authentifier::ADMIN_MEMBER:
    			$aUrls['url_reducer_core_member_account'] 	= 'espace administration';
    		case Authentifier::BASIC_MEMBER:
    			$sMessage = 'Bonjour, ' . $oAuthentifier->getMember()->getPseudo();
    			
    			$aUrls['url_reducer_core_member_account'] = 'mon compte';
    			$aUrls['url_reducer_core_member_logout'] = 'logout';
    			break;
    	}

    	if (array_key_exists($sRoute, $aUrls)) {
    		unset($aUrls[$sRoute]);
    	}

    	$oResponse = $this->render(
            'UrlReducerCoreBundle:Member:menu.member.html.twig',
            array(
            	'menu_message' => $sMessage,
            	'menu_urls' => $aUrls
            )
        );

        return $oResponse;
    }

    /**
     *
     */
    public function memberMenuAction($sRoute) {
    	$oAuthentifier = $this->container->get('url_reducer_core.authentifier');

    	$aUrls = array();

    	switch ($oAuthentifier->getStatus()) {
    		case Authentifier::IS_VISITOR:
    			$sMessage = 'Bienvenue';
    			
    			$aUrls['url_reducer_core_member_login'] 	= 'login';
    			$aUrls['url_reducer_core_member_register'] 	= 'inscription';
    			break;
    		case Authentifier::ADMIN_MEMBER:
    			$aUrls['url_reducer_core_member_admin'] 	= 'espace administration';
    		case Authentifier::BASIC_MEMBER:
    			$sMessage = 'Bonjour, ' . $oAuthentifier->getMember()->getPseudo();
    			
    			$aUrls['url_reducer_core_member_account'] = 'mon compte';
    			$aUrls['url_reducer_core_member_logout'] = 'logout';
    			break;
    	}

    	if (array_key_exists($sRoute, $aUrls)) {
    		unset($aUrls[$sRoute]);
    	}

    	$oResponse = $this->render(
            'UrlReducerCoreBundle:Member:menu.member.html.twig',
            array(
            	'menu_message' => $sMessage,
            	'menu_urls' => $aUrls
            )
        );

        return $oResponse;
    }
}

class MemberControllerException extends \Exception {};
