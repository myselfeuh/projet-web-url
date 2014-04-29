<?php

namespace UrlReducer\CoreBundle\Controller;

use Leg\GCharts\Gallery\BarChart;
// use Leg\GoogleChartsBundle\Charts\Gallery\BarChart;
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
		$aDatas = array(200, 100, 50);

		$oChart = new BarChart();

        $oChart->setWidth(300)
               ->setHeight(300)
               ->setDatas($aDatas);

        return $this->get('leg_google_charts')->build($oChart);
	}

	/**
	 *
	 */
	public function getFrequencyByHourPieChart() {
		$aDatas = array(200, 100, 50);

		$oChart = new BarChart();

        $oChart->setWidth(300)
               ->setHeight(300)
               ->setDatas($aDatas);

        return $this->get('leg_google_charts')->build($oChart);
	}

	/**
	 *
	 */
	public function getFrequencyByWeekPieChart() {
		$aDatas = array(200, 100, 50);

		$oChart = new BarChart();

        $oChart->setWidth(300)
               ->setHeight(300)
               ->setDatas($aDatas);

        return $this->get('leg_google_charts')->build($oChart);	
	}
}
