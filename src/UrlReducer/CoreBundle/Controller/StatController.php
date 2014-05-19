<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\DoctrineManager;

class StatController extends Controller {
	/**
	 *
	 */
	public function frequencyAction() {
		$oDatabaseConnection = Doctrine_Manager::getInstance()->connection();  

		return $this->render(
		    'UrlReducerCoreBundle:Stat:stat.layout.html.twig',
		    array(
		    	'chart_data' => array(
    				"line" 			=> $this->getFrequencyLineChart($oDatabaseConnection),
    				"pie_heure" 	=> $this->getFrequencyByHourPieChart($oDatabaseConnection),
    				"pie_semaine" 	=> $this->getFrequencyByWeekPieChart($oDatabaseConnection)
    			)
    		)
		);
	}

	/**
	 *
	 */
	public function getFrequencyLineChart() {
		$sql = "SELECT * FROM utilisations";
		$stmt = $conn->query($sql); // Simple, but has several drawbacks

		return $stmt->fetchAll();
	}

	/**
	 *
	 */
	public function getFrequencyByHourPieChart() {
		return array(
			"HourPieChart2", "HourPieChart3", "HourPieChart4"
		);
	}

	/**
	 *
	 */
	public function getFrequencyByWeekPieChart() {
		return array(
			"WeekPieChart2", "WeekPieChart3", "WeekPieChart4"
		);
	}
}
