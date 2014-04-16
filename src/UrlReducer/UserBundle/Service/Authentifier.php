<?php
// src/UrlReducer/UserBundle/Service/Authentifier.php

namespace UrlReducer\UserBundle\Service;

class Authentifier {
	/**
	 * Possible status of authentification 
	 */
	const IS_VISITOR = 0;
	const IS_MEMBER = 1;
	const IS_ADMIN = 2;

	/**
	 * The user possibly concerned
	 */	
	private $_oUser = null;

	/**
	 * The customer status on the site
	 */	
	private $_iStatus = Authentifier::IS_VISITOR;

	/**
	 * Try to retrieve a user from session
	 *
	 * @param Session - the session object 
	 */
	public function __construct($oSession, $oDoctrine) {
		$iUserId = $oSession->get('user_id');

		if (!empty($iUserId)) {
			$oUserRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:User');
            $this->_oUser = $oUserRepository->find($iUserId);
		}

		$this->getStatus();
	}

	/**
	 * Set the correct current status and returns it
	 *
	 * @return boolean - the customer's status
	 */
	public function getStatus() {
		if ($this->_oUser == null) {
			$this->_iStatus = Authentifier::IS_VISITOR;
		} else if ($this->_oUser->getProfil() == 'admin') {
			$this->_iStatus = Authentifier::IS_ADMIN;
		} else {
			$this->_iStatus = Authentifier::IS_MEMBER;
		}

		return $this->_iStatus;
	}

	/**
	 * Return the current customer (or null if the isn't)
	 *
	 * @return boolean - the customer
	 */
	public function getUser() {
		return $this->_oUser;
	}

	/**
	 * Return true if customer is not connected (simple visitor)
	 */
	public function isVisitor() {
		return ($this->_iStatus == Authentifier::IS_VISITOR);
	}

	/**
	 * Return true if customer is user, but not admin
	 */
	public function isUser() {
		return ($this->_iStatus == Authentifier::IS_MEMBER);
	}

	/**
	 * Return true if customer is admin
	 */
	public function isAdmin() {
		return ($this->_iStatus == Authentifier::IS_ADMIN);
	}
}