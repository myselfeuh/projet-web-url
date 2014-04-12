<?php
// src/UrlReducer/CoreBundle/Service/Authentifier.php

namespace UrlReducer\CoreBundle\Service;

class Authentifier {
	/**
	 * Possible status of authentification 
	 */
	const IS_VISITOR = 0;
	const BASIC_MEMBER = 1;
	const ADMIN_MEMBER = 2;

	/**
	 * The member possibly concerned
	 */	
	private $_oMember = null;

	/**
	 * The customer status on the site
	 */	
	private $_iStatus = Authentifier::IS_VISITOR;

	/**
	 * Try to retrieve a member from session
	 *
	 * @param Session - the session object 
	 */
	public function __construct($oSession, $oDoctrine) {
		$iMemberId = $oSession->get('member_id');

		if (!empty($iMemberId)) {
			$oMemberRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Membre');
            $this->_oMember = $oMemberRepository->find($iMemberId);
		}

		$this->getStatus();
	}

	/**
	 * Set the correct current status and returns it
	 *
	 * @return boolean - the customer's status
	 */
	public function getStatus() {
		if ($this->_oMember == null) {
			$this->_iStatus = Authentifier::IS_VISITOR;
		} else if ($this->_oMember->getProfil() == 'admin') {
			$this->_iStatus = Authentifier::ADMIN_MEMBER;
		} else {
			$this->_iStatus = Authentifier::BASIC_MEMBER;
		}

		return $this->_iStatus;
	}

	/**
	 * Return the current customer (or null if the isn't)
	 *
	 * @return boolean - the customer
	 */
	public function getMember() {
		return $this->_oMember;
	}

	/**
	 * Return true if customer is not connected (simple visitor)
	 */
	public function isVisitor() {
		return ($this->_iStatus == Authentifier::IS_VISITOR);
	}

	/**
	 * Return true if customer is member, but not admin
	 */
	public function isMember() {
		return ($this->_iStatus == Authentifier::BASIC_MEMBER);
	}

	/**
	 * Return true if customer is admin
	 */
	public function isAdmin() {
		return ($this->_iStatus == Authentifier::ADMIN_MEMBER);
	}

	/**
	 * Return a set of mapped label and urls for menu
	 */
	public function generateMemberMenuUrls() {
		$aMenuItems = array();

		if ($this->isVisitor()) {
			$aMenuItems['login'] = $this->generateUrl('url_reducer_core_member_login');
			$aMenuItems['inscription'] = $this->generateUrl('url_reducer_core_member_register');
		} else {
			$aMenuItems['mon compte'] = $this->generateUrl('url_reducer_core_member_login');
			$aMenuItems['mes statistiques'] = $this->generateUrl('url_reducer_core_member_register');

			if ($this->isAdmin()) {
				$aMenuItems['espace administrateur'] = $this->generateUrl('url_reducer_core_member_admin');
			}
		}

		return $aMenuItems;
	}
}