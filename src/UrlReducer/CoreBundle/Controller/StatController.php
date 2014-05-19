<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatController extends Controller {

	//
	private $aOptions = array();

	/**
	 *
	 */
	public function frequencyAction() {
		$oConnection = $this->getDoctrine()->getEntityManager()->getConnection();

		return $this->render(
		    'UrlReducerCoreBundle:Stat:stat.layout.html.twig',
		    array(
		    	'chart_data' => array(
    				"line" 			=> $this->parse($this->getFrequencyLineChart($oConnection)),
    				"pie_heure" 	=> $this->getFrequencyByHourPieChart($oConnection),
    				"pie_semaine" 	=> $this->getFrequencyByWeekPieChart($oConnection)
    			)
    		)
		);
	}

	private function parse($aResultSet) {

		echo '<pre>';
		var_dump($aResultSet);
		echo '</pre>';

		array(1) {
		  [0]=>
		  array(2) {
		    ["day_date"]=>
		    string(10) "2014-05-18"
		    ["nb_utilisations"]=>
		    string(1) "1"
		  }
		}

		$aJsonStructure["rows"] = array();

		foreach ($aResultSet as $sKey => $mValue) {

		}

		$aJsonStructure = array(
			"cols" => array(
				0 => array(
					"id" 		=> "",
					"label" 	=> "Topping",
					"pattern" 	=> "",
					"type" 		=> "string"
				),

				1 => array(
					"id" 		=> "",
					"label" 	=> "Nb d'utilisation",
					"pattern" 	=> "",
					"type" 		=> "number"
				),
			),

			"rows" => array(
				0 => array(
					"c" => array(
						0 => array(
							"v" => "Onions",
							"f" => null
						),

						1 => array(
							"v" => 1,
							"f" => null
						)
					),
				),

				1 => array(
					"c" => array(
						0 => array(
							"v" => "Onions",
							"f" => null
						),

						1 => array(
							"v" => 10,
							"f" => null
						)
					),
				),

				2 => array(
					"c" => array(
						0 => array(
							"v" => "Onions",
							"f" => null
						),

						1 => array(
							"v" => 100,
							"f" => null
						)
					),
				),

				3 => array(
					"c" => array(
						0 => array(
							"v" => "Onions",
							"f" => null
						),

						1 => array(
							"v" => 1,
							"f" => null
						)
					)
				)
			)
		);

		return $aJsonStructure;
	}

	/**
	 *
	 */
	public function getFrequencyLineChart($oConnection) {
		$this->aOptions = array("Nb d'utilisation", "number");

		$sQuery = '
			SELECT
				DATE(date) as day_date,
				COUNT(1) AS nb_utilisations
			FROM
				utilisations
			GROUP BY
				day_date
		';

		$oStatement = $oConnection->prepare($sQuery);
		$oStatement->execute();

		return $oStatement->fetchAll();
	}

	/**
	 *
	 */
	public function getFrequencyByHourPieChart($oConnection) {
		return array(
			"HourPieChart2", "HourPieChart3", "HourPieChart4"
		);
	}

	/**
	 *
	 */
	public function getFrequencyByWeekPieChart($oConnection) {
		return array(
			"WeekPieChart2", "WeekPieChart3", "WeekPieChart4"
		);
	}
}
