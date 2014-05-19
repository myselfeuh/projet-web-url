<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatController extends Controller {
	/**
	 *
	 */
	public function frequencyAction() {
		return $this->render(
		    'UrlReducerCoreBundle:Stat:stat.layout.html.twig',
		    array(
		    	'chart_data' => array(
    				"Taux d'usage" 				=> $this->getFrequencyLineChart(),
    				"Répartition par heure" 	=> $this->getFrequencyByHourPieChart(),
    				"Répartition par semaine" 	=> $this->getFrequencyByWeekPieChart()
    			)
    		)
		);
	}

	/**
	 *
	 */
	public function getFrequencyLineChart() {
		return array(
			"LineChart2", "LineChart3", "LineChart4"
		);
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
