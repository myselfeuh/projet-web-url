<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\Membre;

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

        	$sCryptedPassword = crypt($sPassword, 'CRYPT_BLOWFISH');

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

	    if ($oFormRegister->isValid()) {
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
            	$oFlashBag->add('user_flash', 'First user registered must be an admin');
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
	    } else {
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
}
