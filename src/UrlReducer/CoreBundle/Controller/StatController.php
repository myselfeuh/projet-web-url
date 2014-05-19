<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatController extends Controller {
	/**
	 *
	 */
	public function frequencyAction() {
		$oConnection = $this->getDoctrine()->getEntityManager()->getConnection();

		return $this->render(
		    'UrlReducerCoreBundle:Stat:stat.layout.html.twig',
		    array(
		    	'chart_data' => array(
    				"line" 			=> $this->getFrequencyLineChart($oConnection),
    				"pie_heure" 	=> $this->getFrequencyByHourPieChart($oConnection),
    				"pie_semaine" 	=> $this->getFrequencyByWeekPieChart($oConnection)
    			)
    		)
		);
	}

	private function parse() {
		
	}

	/**
	 *
	 */
	public function getFrequencyLineChart($oConnection) {
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
