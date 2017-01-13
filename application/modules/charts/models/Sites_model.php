<?php
defined('BASEPATH') or exit();

/**
* 
*/
class Sites_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}


	function sites_outcomes($year=null,$month=null,$partner=null)
	{
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_year');
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

		if ($partner) {
			$sql = "CALL `proc_get_partner_sites_outcomes`('".$partner."','".$year."','".$month."')";
		}  else {
			$sql = "CALL `proc_get_all_sites_outcomes`('".$year."','".$month."')";
		}
		// $sql = "CALL `proc_get_all_sites_outcomes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['sites_outcomes'][0]['name'] = 'Not Suppresed';
		$data['sites_outcomes'][1]['name'] = 'Suppresed';

		$count = 0;
		
		$data["sites_outcomes"][0]["data"][0]	= $count;
		$data["sites_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["sites_outcomes"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["sites_outcomes"][1]["data"][$key]	=  (int) $value['suppressed'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function partner_sites_outcomes($year=NULL,$month=NULL,$site=NULL,$partner=NULL)
	{
		$table = '';
		$count = 1;
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

		$sql = "CALL `proc_get_partner_sites_details`('".$partner."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			$table .= '<td>'.$value['MFLCode'].'</td>';
			$table .= '<td>'.$value['name'].'</td>';
			$table .= '<td>'.$value['county'].'</td>';
			$table .= '<td>'.$value['tests'].'</td>';
			$table .= '<td>'.$value['sustxfail'].'</td>';
			$table .= '<td>'.$value['confirmtx'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['paeds'].'</td>';
			$table .= '<td>'.$value['maletest'].'</td>';
			$table .= '<td>'.$value['femaletest'].'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

	function sites_trends($year=null,$month=null,$site=null)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}
		$data['year'] = $year;

		$sql = "CALL `proc_get_sites_trends`('".$site."','".$year."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$count = 0;


		$data['test_trends'][0]['name'] = 'Tests';
		$data['test_trends'][1]['name'] = 'Suppressed';
		$data['test_trends'][2]['name'] = 'Non Suppressed';
		$data['test_trends'][3]['name'] = 'Rejected';

		$data['test_trends'][0]['data'][0] = $count;
		$data['test_trends'][1]['data'][0] = $count;
		$data['test_trends'][2]['data'][0] = $count;
		$data['test_trends'][3]['data'][0] = $count;

		foreach ($months as $key1 => $value1) {
			foreach ($result as $key2 => $value2) {
				if ((int) $value1 == (int) $value2['month']) {
					$data['test_trends'][0]['data'][$count] = (int) $value2['alltests'];
					$data['test_trends'][1]['data'][$count] = (int) $value2['undetected']+(int) $value2['less1000'];
					$data['test_trends'][2]['data'][$count] = (int) $value2['less5000']+(int) $value2['above5000'];
					$data['test_trends'][3]['data'][$count] = (int) $value2['rejected'];

					$count++;
				}
				
			}
		}
		
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	// Not Possible
	function site_outcomes_chart($year=null,$month=null,$site=null)
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
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}
		
		$sql = "CALL `proc_get_sites_sample_types`('".$site."','".$year."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);

		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'] = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;

		foreach ($months as $key => $value) {
			foreach ($result as $key1 => $value1) {
				if ((int) $value == (int) $value1['month']) {
					$data["sample_types"][0]["data"][$key]	= (int) $value1['edta'];
					$data["sample_types"][1]["data"][$key]	= (int) $value1['dbs'];
					$data["sample_types"][2]["data"][$key]	= (int) $value1['plasma'];

					$count++;
				}
				
			}
		}
		 // echo "<pre>";print_r($data);die();
		return $data;
	}

	function sites_vloutcomes($year=null,$month=null,$site=null)
	{
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
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

		$sql = "CALL `proc_get_sites_vl_outcomes`('".$site."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
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
			$data['ul'] .= '<li>Total Tests: '.$value['alltests'].'</li>';
			$data['ul'] .= '<li>Suspected Tx Failures: '.$value['sustxfail'].' <strong>('.(int) (($value['sustxfail']/$value['alltests'])*100).'%)</strong></li>';
			$data['ul'] .= '<li>Total Repeat VL: '.$value['confirm2vl'].'</li>';
			$data['ul'] .= '<li>Confirmed Tx Failure: '.$value['confirmtx'].'</li>';
			$data['ul'] .= '<li>Rejected: '.$value['rejected'].'</li>';
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected']+(int) $value['less1000'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less5000']+(int) $value['above5000'];

			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#F2784B';
		}

		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;
		
		return $data;
	}

	function sites_age($year=null,$month=null,$site=null)
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
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		$sql = "CALL `proc_get_sites_age`('".$site."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['ageGnd']['name'] = 'Tests';
		
		$count = 0;
		$categories = array('less2','less9','less14','less19','less24','over25');
		
		$data["ageGnd"]["data"][0]	=  NULL;
		$data["ageGnd"]["data"][1]	=  NULL;
		$data["ageGnd"]["data"][2]	=  NULL;
		$data["ageGnd"]["data"][3]	=  NULL;
		$data["ageGnd"]["data"][4]	=  NULL;
		$data["ageGnd"]["data"][5]	=  NULL;
		$data['categories'][0]		= 'No Data';

		if ($result) {
			foreach ($result as $key => $value) {
				$data['categories']			= 	$categories;
				$data["ageGnd"]["data"][0]	=  (int) $value['less2'];
				$data["ageGnd"]["data"][1]	=  (int) $value['less9'];
				$data["ageGnd"]["data"][2]	=  (int) $value['less14'];
				$data["ageGnd"]["data"][3]	=  (int) $value['less19'];
				$data["ageGnd"]["data"][4]	=  (int) $value['less24'];
				$data["ageGnd"]["data"][5]	=  (int) $value['over25'];
			}
		}
		$data["ageGnd"]["color"] =  '#1BA39C';

		return $data;
	}

	function sites_gender($year=null,$month=null,$site=null)
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
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		$sql = "CALL `proc_get_sites_gender`('".$site."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['Gnd']['name'] = 'Tests';
		
		$count = 0;
		$categories = array('Male','Female');
		
		$data["Gnd"]["data"][0]	=  NULL;
		$data["Gnd"]["data"][1]	=  NULL;
		$data['categories'][0]		= 'No Data';

		if ($result) {
			foreach ($result as $key => $value) {
				$data['categories']			= 	$categories;
				$data["Gnd"]["data"][0]	=  (int) $value['male'];
				$data["Gnd"]["data"][1]	=  (int) $value['female'];
			}
		}
		$data["Gnd"]["color"] =  '#1BA39C';

		return $data;
	}

	function partner_sites_outcomes_download($year=NULL,$month=NULL,$partner=NULL)
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

		$sql = "CALL `proc_get_partner_sites_details`('".$partner."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($data);die();
		

		// $this->load->helper('download');
  //       $this->load->library('PHPReport/PHPReport');

  //       ini_set('memory_limit','-1');
	 //    ini_set('max_execution_time', 900);


  //       $template = 'partner_sites.xlsx';

	 //    //set absolute path to directory with template files
	 //    $templateDir = __DIR__ . "/";
	    
	 //    //set config for report
	 //    $config = array(
	 //        'template' => $template,
	 //        'templateDir' => $templateDir
	 //    );


	 //      //load template
	 //    $R = new PHPReport($config);
	    
	 //    $R->load(array(
	 //            'id' => 'data',
	 //            'repeat' => TRUE,
	 //            'data' => $data   
	 //        )
	 //    );
	      
	 //      // define output directoy 
	 //    $output_file_dir = __DIR__ ."/tmp/";
	 //     // echo "<pre>";print_r("Still working");die();

	 //    $output_file_excel = $output_file_dir  . "partner_sites.xlsx";
	 //    //download excel sheet with data in /tmp folder
	 //    $result = $R->render('excel', $output_file_excel);
	 //    force_download($output_file_excel, null);	

        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('MFL Code', 'Name', 'County', 'Tests', '>1000cp/ml', 'Confirm Repeat Tests', 'Rejected', 'Adult Tests', 'Peads Tests', 'Male', 'Female');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="vl_partner_sites.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
		
	}
}
?>