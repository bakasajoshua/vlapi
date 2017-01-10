<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Trendapi_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function yearly_trends($county=NULL){

		$url;
		$b = true;

		if ($county == NULL || $county == 0) {
			$url = 'https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[';
		} else {
			$url = 'https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[';
			$b = false;
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

			$extract;

			if($b){
				$extract = $info['data']['Period'];
			}
			else{
				$extract = $info['data'][0]['Period'];
			}

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
		echo "<pre>";print_r($data);echo "</pre>";die();

		return $data;
	}

	function yearly_summary($county=NULL){

		$url;
		$b = true;

		if ($county == NULL || $county == 0) {
			$url = 'https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[';
		} else {
			$url = 'https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[';
			$b = false;
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

			$extract;

			if($b){
				$extract = $info['data']['Period'];
			}
			else{
				$extract = $info['data'][0]['Period'];
			}
			
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
	}




}