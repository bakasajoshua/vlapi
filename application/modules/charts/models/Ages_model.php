<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Ages_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function ages_outcomes($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$sql = "CALL `proc_get_vl_age_outcomes`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['suppressed'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function ages_vl_outcomes($year=NULL,$month=NULL,$age_cat=NULL)
	{
		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
		}
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$sql = "CALL `proc_get_vl_age_vl_outcomes`('".$age_cat."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = 'Suppresed';
		$data['vl_outcomes']['data'][1]['name'] = 'Not Suppresed';

		$count = 0;

		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;

		foreach ($result as $key => $value) {
			$data['ul'] .= '<tr>
	    		<td colspan="2">Total Tests:</td>
	    		<td colspan="2">'.number_format($value['alltests']).'</td>
	    	</tr>
	    	<tr>
	    		<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Outcomes:</td>
	    		<td colspan="2">'.number_format($value['undetected']+$value['less1000']+$value['less5000']+$value['above5000']).'</td>
	    	</tr>
	    	<tr>
	    		<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Suspected Tx Failure:</td>
	    		<td colspan="2">'.number_format($value['sustxfail']).' <strong>('.(int) (($value['sustxfail']/($value['undetected']+$value['less1000']+$value['less5000']+$value['above5000']))*100).'%)</strong></td>
	    	</tr>
	    	<tr>
	    		<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invalid Outcomes:</td>
	    		<td colspan="2">'.number_format($value['invalids']).'</td>
	    	</tr>
	    	<tr>
	    		<td colspan="2">Total Repeat VL:</td>
	    		<td colspan="2">'.number_format($value['confirm2vl']).'</td>
	    	</tr>
	    	<tr>
	    		<td colspan="2">Confirmed Tx Failure:</td>
	    		<td colspan="2">'.number_format($value['confirmtx']).'</td>
	    	</tr>
	    	<tr>
	    		<td>Rejected:</td>
	    		<td>'.number_format($value['rejected']).'</td>';
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected']+(int) $value['less1000'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less5000']+(int) $value['above5000'];

			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#F2784B';
		}
		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;
		
		return $data;
	}

	function ages_gender($year=NULL,$month=NULL,$age_cat=NULL)
	{
		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
		}
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$sql = "CALL `proc_get_vl_age_gender`('".$age_cat."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['gender'][0]['name'] = 'Test';

		$count = 0;
		
		$data["gender"][0]["data"][0]	= $count;
		$data["gender"][0]["data"][1]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][0] 			= 'Male';
			$data['categories'][1] 			= 'Female';
			$data["gender"][0]["data"][0]	=  (int) $value['maletest'];
			$data["gender"][0]["data"][1]	=  (int) $value['femaletest'];
		}

		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		
		return $data;
	}

	function ages_samples($year=NULL,$age_cat=NULL)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;

		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
		}
		
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;

		$sql = "CALL `proc_get_vl_age_sample_types`('".$age_cat."','".$from."')";
		$sql2 = "CALL `proc_get_vl_age_sample_types`('".$age_cat."','".$to."')";
		// echo "<pre>";print_r($sql);die();
		$array1 = $this->db->query($sql)->result_array();
		
		if ($sql2) {
			$this->db->close();
			$array2 = $this->db->query($sql2)->result_array();
		}

		$result = array_merge($array1,$array2);

		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;

		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];

				$data["sample_types"][0]["data"][$key]	= (int) $value['edta'];
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
				$data["sample_types"][2]["data"][$key]	= (int) $value['plasma'];
			
		}
		
		return $data;
	}
}