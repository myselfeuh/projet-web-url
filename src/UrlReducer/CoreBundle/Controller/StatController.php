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
		$aRenderingData = array();

		$chart = new BarChart();

        $chart  ->setWidth(200)
                ->setHeight(200)
                ->setDatas(array(200, 100, 50));

        $url = $this->get('leg_google_charts')->build($chart);

        $aRenderingData['chart_url'] = $url;

		return $this->render(
		    'UrlReducerCoreBundle:Stat:stat.layout.html.twig', 
		    $aRenderingData
		);
	}
}
