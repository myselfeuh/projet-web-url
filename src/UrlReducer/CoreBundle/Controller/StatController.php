<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PDO;

class StatController extends Controller {
	const LINE 		= 0;
	const HOUR_PIE 	= 1;
	const WEEK_PIE 	= 2;

	const MODE_NORMAL	= 5;
	const MODE_ADMIN	= 6;

	//
	private $aOptions = array();
	private $oUser = null;
	private $iMode = StatController::MODE_NORMAL;

	/**
	 *
	 */
	public function frequencyAction() {
		$oConnection = $this->getDoctrine()->getEntityManager()->getConnection();

		$oAuthentifier = $this->container->get('url_reducer_user.authentifier');
		$this->oUser = $oAuthentifier->getUser();

		if (StatController::MODE_ADMIN && !$oAuthentifier->isAdmin()) {
			// @TODO error
		}

		$aResponse = array(
	    	'chart_data' => array(
				"line" 			=> $this->parse($this->getFrequencyLineChart($oConnection), StatController::LINE),
				"pie_heure" 	=> $this->parse($this->getFrequencyByHourPieChart($oConnection), StatController::HOUR_PIE),
				"pie_semaine" 	=> $this->parse($this->getFrequencyByWeekPieChart($oConnection), StatController::WEEK_PIE)
			)
		);

		if ($oAuthentifier->isAdmin()) {
			if ($this->iMode == StatController::MODE_ADMIN) {
				$aResponse['url'] = array(
					'route' => 'url_reducer_core_stat',
					'label' => 'Voir mes statistiques'
				);
			} else {
				$aResponse['url'] = array(
					'route' => 'url_reducer_core_stat_admin',
					'label' => 'Voir les statistiques globales'
				);
			}
		}

		return $this->render(
		    'UrlReducerCoreBundle:Stat:stat.layout.html.twig',
		    $aResponse
		);
	}

	public function adminAction() {
		$this->iMode = StatController::MODE_ADMIN;

		return $this->frequencyAction();
	}

	private function parse($aResultSet, $type_chart) {
		$aJsonStructure["cols"] = array(
			0 => array(
				"id" 		=> "",
				"label" 	=> "Topping",
				"pattern" 	=> "",
				"type" 		=> "string"
			),

			1 => array(
				"id" 		=> "",
				"label" 	=> $this->aOptions["label"],
				"pattern" 	=> "",
				"type" 		=> $this->aOptions["type"]
			)
		);

		$aJsonStructure["rows"] = array();

		foreach ($aResultSet as $sSetKey => $mSetValue) {
			$sSetKey = array();
			$sSetKey["c"] = array();

			$i = 0;

			foreach ($mSetValue as $sKey => $mValue) {
				$sSetKey["c"][$i] = array();

				$sSetKey["c"][$i]["v"] = (int) $mValue;

				// @fut utile
				/* switch ($type_chart) {
					case StatController::LINE:
						$sSetKey["c"][$i]["f"] = $mValue;
						break;
					case StatController::HOUR_PIE:
						$sSetKey["c"][$i]["f"] = $mValue;
						break;
					case StatController::WEEK_PIE:
						$sSetKey["c"][$i]["f"] = $mValue;
						break;

					default:
						$sSetKey["c"][$i]["f"] = null;
						break;
				}*/

				$i++;
			}

			$aJsonStructure["rows"][] = $sSetKey;
		}

		return $aJsonStructure;
	}

	/**
	 *
	 */
	public function getFrequencyLineChart($oConnection) {
		$this->aOptions = array(
			"label" => "Nb d'utilisation",
			"type" => "number"
		);

		if ($this->iMode == StatController::MODE_ADMIN) {
			$sWhere = '';
		} else {
			$sWhere = ' AND m.id = :user_id';
		}

		$sQuery = '
			SELECT
				DATE(date) as day_date,
				COUNT(1) AS nb_utilisations
			FROM
				utilisations ut,
				urls u,
				membres m
			WHERE
				ut.url = u.id
				AND u.auteur = m.id
				' . $sWhere . '
			GROUP BY
				day_date
		';

		$user_id = $this->oUser->getId();

		$oStatement = $oConnection->prepare($sQuery);
		$oStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

		$oStatement->execute();

		return $oStatement->fetchAll();
	}

	/**
	 *
	 */
	public function getFrequencyByHourPieChart($oConnection) {
		$this->aOptions = array(
			"label" => "Heure",
			"type" => "number"
		);

		if ($this->iMode == StatController::MODE_ADMIN) {
			$sWhere = '';
		} else {
			$sWhere = ' AND m.id = :user_id';
		}

		$sQuery = '
			SELECT
				DATE_FORMAT(date, "%H") AS hour,
				COUNT(1) AS repartition
			FROM
				utilisations ut,
				urls u,
				membres m
			WHERE
				ut.url = u.id
				AND u.auteur = m.id
				' . $sWhere . '
			GROUP BY
				hour
		';

		$user_id = $this->oUser->getId();

		$oStatement = $oConnection->prepare($sQuery);
		$oStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

		$oStatement->execute();

		return $oStatement->fetchAll();
	}

	/**
	 *
	 */
	public function getFrequencyByWeekPieChart($oConnection) {
		$this->aOptions = array(
			"label" => "Nb d'utilisation",
			"type" => "number"
		);

		if ($this->iMode == StatController::MODE_ADMIN) {
			$sWhere = '';
		} else {
			$sWhere = ' AND m.id = :user_id';
		}

		$sQuery = '
			SELECT
				DAYNAME(date) as day_date,
				COUNT(1) AS nb_utilisations
			FROM
				utilisations ut,
				urls u,
				membres m
			WHERE
				ut.url = u.id
				AND u.auteur = m.id
				' . $sWhere . '
			GROUP BY
				day_date
		';

		$user_id = $this->oUser->getId();

		$oStatement = $oConnection->prepare($sQuery);
		$oStatement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

		$oStatement->execute();

		return $oStatement->fetchAll();
	}
}
