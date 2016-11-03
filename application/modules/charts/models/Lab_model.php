<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Lab_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function lab_testing_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_labs_testing_trends`('".$year."')";

		echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);

		$data['categories'][0] = 'No Data';
		$data['test_trends'][0]['name'] = 'No Data';

		$count = 0;
		foreach ($months as $key => $value) {
			foreach ($result as $k => $v) {
				if ( (int)$value == (int) $v["month"]) {
					$data['test_trends']['name'][$key] = $v['labname'];
					$data['test_trends']['data'][$key] = (int) $['alltests']);
				}
			}
		}
		echo "<pre>";print_r($data);die();
		return $data;
	}

	function lab_rejection_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_labs_testing_trends`('".$year."')";

		echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);

		$data['categories'][0] = 'No Data';

		$count = 0;
		foreach ($result as $key => $value) {

		}

		return $data;
	}
}
?>