<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Partner_trend_api_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function yearly_trends($partner=NULL){

		if($partner == NULL || $partner == 'NA'){
			$partner = 0;
		}
		$url;

		if ($partner == 0) {
			$url = 'https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[';
		} else {
			$url = 'https://api.nascop.org/vl/ver1.0/partner?partnerId=1&aggregationPeriod=[';
		}

		$year = 2012;
		$data;
		$i=0;
		$curryear = date("Y") + 1;

		while($year < $curryear){

			$info = $this->req($url . $year . ']');

			$data['suppression_trends'][$i]['name'] = $year;
			$data['test_trends'][$i]['name'] = $year;
			$data['rejected_trends'][$i]['name'] = $year;
			$data['tat_trends'][$i]['name'] = $year;

			$extract = $info['data']['Period'];

			$month=0;

			foreach($extract as $key => $value) {
				$data['suppression_trends'][$i]['data'][$month] = $value['TestsDone']['NonSuppressed'];
				$data['test_trends'][$i]['data'][$month] = $value['TestsDone']['TotalTests'];
				$data['rejected_trends'][$i]['data'][$month] = $value['TestsDone']['Rejected'];
				$data['tat_trends'][$i]['data'][$month] = $value['TestTAT']['CollectionToDispatch'];
				$month++;
			}
			$year++;
			$i++;
		}

		return $data;
	}

	function yearly_summary($county=NULL){

		if($county == NULL || $county == 48){
			$county = 0;
		}
		$url;

		if ($county == 0) {
			$url = 'https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[';
		} else {
			$url = 'https://api.nascop.org/vl/ver1.0/partner?partnerId=1&aggregationPeriod=[';
		}

		$year = 2012;
		$i=0;
		$curryear = date("Y") + 1;

		$data['outcomes'][0]['name'] = "Nonsuppressed";
		$data['outcomes'][1]['name'] = "Suppressed";
		$data['outcomes'][2]['name'] = "Suppression";


		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "Outcomes";

		while($year < $curryear){

			$info = $this->req($url . $year . ']');

			$data['categories'][$i] = $year;

			$extract = $info['data']['Period'];

			$data['outcomes'][0]['data'][$i] = 0;
			$data['outcomes'][1]['data'][$i] = 0;

			foreach($extract as $key => $value) {
				$data['outcomes'][0]['data'][$i] += $value['TestsDone']['NonSuppressed'];
				$data['outcomes'][1]['data'][$i] += $value['TestsDone']['Suppressed'];
			}
			$nonsup = $data['outcomes'][0]['data'][$i];
			$sup = $data['outcomes'][1]['data'][$i];
			$data['outcomes'][2]['data'][$i] = round(@(((int) $sup*100)/((int) $sup+(int) $nonsup)),1);
			$year++;
			$i++;
		}

		return $data;


		
		
		// echo "<pre>";print_r($result);die();
		$year = date("Y");
		$i = 0;

		

		foreach ($result as $key => $value) {
			$data['categories'][$i] = $value['year'];
			
			$data['outcomes'][0]['data'][$i] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$i] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$i] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
			$i++;
		}
		

		return $data;
	}




}