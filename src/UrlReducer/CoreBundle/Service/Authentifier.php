<?php
// src/UrlReducer/CoreBundle/Service/Authentifier.php

namespace UrlReducer\CoreBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class Authentifier {
	/**
	 * Possible status of authentification 
	 */
	const NOT_CONNECTED = 0;
	const BASIC_MEMBER = 1;
	const ADMIN_MEMBER = 2;

	/**
	 * The member possibly concerned
	 */	
	private $_oMember = null;

	/**
	 * The customer status on the site
	 */	
	private $_iStatus = Authentifier::NOT_CONNECTED;

	/**
	 * Try to retrieve a member from session
	 *
	 * @param Session - the session object 
	 */
	public function __construct(Session $oSession) {
		$iMemberId = $oSession->get('member_id');

		if (!empty($iMemberId)) {
			$oMemberRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Membre');
            $this->_oMember = $oMemberRepository->find($iMemberId);
		}

		$this->getStatus();
	}

	/**
	 * Try to retrieve a member from session
	 *
	 * @param Session - the session object 
	 */
	// public function init(Session $oSession) {
	// 	$iMemberId = $oSession->get('member_id');

	// 	if (!empty($iMemberId)) {
	// 		$oMemberRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Membre');
 //            $this->_oMember = $oMemberRepository->find($iMemberId);
	// 	}

	// 	$this->getStatus();
	// }

	/**
	 * Set the correct current status
	 */
	public function getStatus() {
		if ($this->_oMember == null) {
			$this->_iStatus = Authentifier::NOT_CONNECTED;
		} else if ($this->_oMember->getProfil() == 'admin') {
			$this->_iStatus = Authentifier::ADMIN_MEMBER;
		} else {
			$this->_iStatus = Authentifier::BASIC_MEMBER;
		}
	}

	/**
	 * Return true if customer is admin
	 */
	public function isAdmin() {
		return ($this->_iStatus == Authentifier::ADMIN_MEMBER);
	}

	/**
	 * Return true if customer is connected (Member or Admin)
	 */
	public function isConnected() {
		return ($this->_iStatus != Authentifier::NOT_CONNECTED);
	}

	/**
	 * Generate the templates code for the views
	 */
	public function createViewHelper($bIsConnected = false) {
		
	}


}