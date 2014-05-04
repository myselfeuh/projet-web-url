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
		    	'chart_urls' => array(
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
		return true;
	}

	/**
	 *
	 */
	public function getFrequencyByHourPieChart() {
		return true;
	}	

	/**
	 *
	 */
	public function getFrequencyByWeekPieChart() {
		return true;
	}
}
