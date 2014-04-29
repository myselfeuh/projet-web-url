<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UrlReducer\UserBundle\Service\Authentifier;

/**
 *
 */
class MenuController extends Controller {
    /**
     *
     */
    public function userAction($sRoute) {
		$oAuthentifier = $this->container->get('url_reducer_user.authentifier');

		$aMenuEntries = array();

		switch ($oAuthentifier->getStatus()) {
			case Authentifier::IS_VISITOR:
				$sMessage = 'Bienvenue';
				
				$aMenuEntries['url_reducer_user_login'] 	= 'login';
				$aMenuEntries['url_reducer_user_register'] = 'inscription';
				break;
			case Authentifier::IS_ADMIN:
			case Authentifier::IS_MEMBER:
				$sMessage = 'Bonjour, ' . $oAuthentifier->getUser()->getPseudo();
				$aMenuEntries['url_reducer_user_logout'] = 'logout';
				break;
		}

		// if (array_key_exists($sRoute, $aMenuEntries)) {
		// 	unset($aMenuEntries[$sRoute]);
		// }

		$oResponse = $this->render(
	        'UrlReducerCoreBundle:Menu:user.menu.html.twig',
	        array(
	        	'menu_message' => $sMessage,
	        	'menu_urls' => $aMenuEntries
	        )
	    );

	    return $oResponse;
    }

    /**
     *
     */
    public function memberAction() {
    	$oAuthentifier = $this->container->get('url_reducer_user.authentifier');

		$aMenuEntries = array();

		if ($oAuthentifier->getStatus() >= Authentifier::IS_MEMBER) {
			$aMenuEntries['url_reducer_core_url_list'] 		= 'gérer mes urls';
			$aMenuEntries['url_reducer_core_stat'] 			= 'voir mes statistiques';
			$aMenuEntries['url_reducer_user_modify'] 		= 'modifier mes informations';
		}

		if ($oAuthentifier->getStatus() == Authentifier::IS_ADMIN) {
			$aMenuEntries['url_reducer_user_manage'] 		= 'gérer les utilisateurs';
		}

		$oResponse = $this->render(
	        'UrlReducerCoreBundle:Menu:member.menu.html.twig',
	        array('menu_urls' => $aMenuEntries)
	    );

	    return $oResponse;
    }

    /**
     *
     */
    public function statAction() {
    	$oAuthentifier = $this->container->get('url_reducer_user.authentifier');

		$aMenuEntries = array();

		if ($oAuthentifier->getStatus() >= Authentifier::IS_MEMBER) {
			$aMenuEntries['url_reducer_core_stat']				= "Taux global";
			$aMenuEntries['url_reducer_core_stat_by_week'] 		= "Par jour de la semaine";
			$aMenuEntries['url_reducer_core_stat_by_hour'] 		= "Par heure de la journée";
		}

		if ($oAuthentifier->getStatus() == Authentifier::IS_ADMIN) {
			$aMenuEntries['url_reducer_core_stat_global'] 		= "Taux cumulé (toutes les urls)";
		}

		$oResponse = $this->render(
	        'UrlReducerCoreBundle:Menu:stat.menu.html.twig',
	        array('menu_urls' => $aMenuEntries)
	    );

	    return $oResponse;
    }

}
