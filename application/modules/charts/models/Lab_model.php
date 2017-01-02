<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Lab_model extends MY_Model
{

	function lab_performance_stat($year=NULL,$month=NULL)
	{
		// echo round(3.6451895227869, 2, PHP_ROUND_HALF_UP);die();
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

		$sql = "CALL `proc_get_vl_lab_performance_stats`('".$year."','".$month."');";

		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);echo "</pre>";die();
		$ul = '';
		foreach ($result as $key => $value) {
			$ul .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['name']."</td>
						<td>".(int) $value['sitesending']."</td>
						<td>".(int) $value['received']."</td>
						<td>".(int) $value['rejected'] . " (" . 
							round((($value['rejected']*100)/$value['received']), 4, PHP_ROUND_HALF_UP)."%)</td>
						<td>".(int) $value['invalids']."</td>

						<td>".(int) $value['alltests']."</td>
						<td>".((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000'])."</td>
						<td>".(int) $value['eqa']."</td>
						<td>".(int) $value['confirmtx']."</td>
						<td>".((int) $value['alltests'] + (int) $value['eqa'] + (int) $value['confirmtx'])."</td>

						<td>".( (int) $value['less5000'] + (int) $value['above5000'])."</td>
						
						<td>".round(((($value['less5000'] + $value['above5000'])*100)/($value['undetected'] + $value['less1000'] + $value['less5000'] + $value['above5000'])), 2, PHP_ROUND_HALF_UP)."%</td>

						<td>".((int) $value['undetected'] + (int) $value['less1000'])."</td>

						<td>".round(((($value['undetected'] + $value['less1000'])*100)/($value['undetected'] + $value['less1000'] + $value['less5000'] + $value['above5000'])), 2, PHP_ROUND_HALF_UP)."%</td>

						
					</tr>";
		}

		return $ul;
	}

	function download_lab_performance_stats($year, $month){

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

		$sql = "CALL `proc_get_vl_lab_performance_stats`('".$year."','".$month."');";

		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "labs.csv";
        $result = $this->db->query($sql)->result_array();
        
        $sheet;

        foreach ($result as $key => $value) {
			$sheet[$key]['name'] = $value['name'];
			$sheet[$key]['sites_sending'] = (int) $value['sitesending'];
			$sheet[$key]['received'] = (int) $value['received'];
			$sheet[$key]['rejected'] = (int) $value['rejected'];
			$sheet[$key]['rejection_rate'] = round((($value['rejected']*100)/$value['received']), 4, PHP_ROUND_HALF_UP)."%";
			$sheet[$key]['invalid_tests'] = (int) $value['invalids'];
			$sheet[$key]['all_tests'] = (int) $value['alltests'];
			$sheet[$key]['valid_tests'] = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$sheet[$key]['eqa'] = (int) $value['eqa'];
			$sheet[$key]['confirmatory_repeat_tests'] = (int) $value['confirmtx'];
			$sheet[$key]['total_tests'] = ((int) $value['alltests'] + (int) $value['eqa'] + (int) $value['confirmtx']);
			$sheet[$key]['>1000_copies'] = ( (int) $value['less5000'] + (int) $value['above5000']);
			$sheet[$key]['>1000_copies5'] = round(((($value['less5000'] + $value['above5000'])*100)/($value['undetected'] + $value['less1000'] + $value['less5000'] + $value['above5000'])), 2, PHP_ROUND_HALF_UP) . "%";
			$sheet[$key]['<1000_copies'] = ((int) $value['undetected'] + (int) $value['less1000']);
			$sheet[$key]['<1000_copies%'] = round(((($value['undetected'] + $value['less1000'])*100)/($value['undetected'] + $value['less1000'] + $value['less5000'] + $value['above5000'])), 2, PHP_ROUND_HALF_UP) . "%";
						
		}

		// echo "<pre>";print_r($sheet);die();

  //       $data = $this->dbutil->csv_from_result($sheet, $delimiter, $newline);
  //       force_download($filename, $data);

		 /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('Testing Lab', 'Facilities Served', 'Total Samples Received', 'Rejected Samples (on receipt at lab)', 'Rejection Rate', 'Redraws (after testing)', 'All Samples Run', 'Valid Test Results', 'EQA QA/IQC Tests', 'Confirmatory Repeat Tests', 'Total Tests Performed', '>1000 copies/ml', '%>1000 copies/ml', '<1000 copies/ml', '%<1000 copies/ml');

	    fputcsv($f, $b, $delimiter);

	    foreach ($sheet as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="labs.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	}
	
	function lab_testing_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_labs_testing_trends`('".$year."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		if ($result) {
			$categories = array();
			foreach ($result as $key => $value) {
				if (!in_array($value['labname'], $categories)) {
					$categories[] = $value['labname'];
				}
			}

			$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
			$count = 0;
			foreach ($categories as $key => $value) {
				foreach ($months as $key1 => $value1) {
					foreach ($result as $key2 => $value2) {
						if ((int) $value1 == (int) $value2['month'] && $value == $value2['labname']) {
							$data['test_trends'][$key]['name'] = $value;
							$data['test_trends'][$key]['data'][$count] = (int) $value2['alltests'];
						}
					}
					$count++;
				}
				$count = 0;
			}
		} else {
			echo "<pre>";print_r("NO TESTING TRENDS DATA FOUND FOR THE SELECTED PERIOD!");echo "</pre>";die();
		}

		
		$this->db->close();

		$sql2 = "CALL `proc_get_avg_labs_testing_trends`('".$year."')";
		$result2 = $this->db->query($sql2)->result_array();

		$i = count($data['test_trends']);
		$count = 0;
		foreach ($result2 as $key => $value) {
				
			$data['test_trends'][$i]['name'] = 'Average Lab Testing Volumes';
			$data['test_trends'][$i]['data'][$count] = (int) $value['alltests'];
			$count++;
		}

		
		//echo "<pre>";print_r($result2);die();
		return $data;
	}

	function lab_rejection_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_labs_testing_trends`('".$year."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		if ($result) {
			$categories = array();
			foreach ($result as $key => $value) {
				if (!in_array($value['labname'], $categories)) {
					$categories[] = $value['labname'];
				}
			}

			$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
			$count = 0;
			foreach ($categories as $key => $value) {
				foreach ($months as $key1 => $value1) {
					foreach ($result as $key2 => $value2) {
						if ((int) $value1 == (int) $value2['month'] && $value == $value2['labname']) {
							$data['reject_trend'][$key]['name'] = $value;
							$data['reject_trend'][$key]['data'][$count] = round(@((int) $value2['rejected'] * 100 / (int) $value2['received']), 2);
						}
					}
					$count++;
				}
				$count = 0;
			}
		} else {
			echo "<pre>";print_r("NO REJECTION TRENDS DATA FOUND FOR THE SELECTED PERIOD!");echo "</pre>";die();
		}

		$this->db->close();

		$sql2 = "CALL `proc_get_avg_labs_testing_trends`('".$year."')";
		$result2 = $this->db->query($sql2)->result_array();

		$i = count($data['reject_trend']);
		$count = 0;
		foreach ($result2 as $key => $value) {
				
			$data['reject_trend'][$i]['name'] = 'National Rejection Rate';
			$data['reject_trend'][$i]['data'][$count] = round(@((int) $value['rejected'] * 100 / (int) $value['received']), 2);
			$count++;
		}

		return $data;
	}

	function sample_types($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		
		$sql = "CALL `proc_get_labs_sampletypes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;
		if ($result) {
			foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $value['labname'];

				$data["sample_types"][0]["data"][$key]	= (int) $value['edta'];
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
				$data["sample_types"][2]["data"][$key]	= (int) $value['plasma'];
			
			}
		}

		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function labs_turnaround($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_labs_tat`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$lab = NULL;
		$count = 1;
		$tat1 = 0;
		$tat2 = 0;
		$tat3 = 0;
		$tat4 = 0;
		$tat = array();
		
		if ($result) {
			foreach ($result as $key => $value) {
				
					$labname = strtolower(str_replace(" ", "_", $value['labname']));
					if ($lab) {
						if ($lab==$value['labname']) {
							$tat1 = $tat1+$value['tat1'];
							$tat2 = $tat2+$value['tat2'];
							$tat3 = $tat3+$value['tat3'];
							$tat4 = $tat4+$value['tat4'];
							$tat[$labname] = array(
										'lab' => $labname,
										'tat1' => $tat1,
										'tat2' => $tat2,
										'tat3' => $tat3,
										'tat4' => $tat4,
										'count' => $count
										);
							$count++;
						} else {
							$count = 1;
							$tat1 = $value['tat1'];
							$tat2 = $value['tat2'];
							$tat3 = $value['tat3'];
							$tat4 = $value['tat4'];
							$lab = $value['labname'];
							$tat[$labname] = array(
										'lab' => $labname,
										'tat1' => $tat1,
										'tat2' => $tat2,
										'tat3' => $tat3,
										'tat4' => $tat4,
										'count' => $count
										);
							$count++;
						}
					} else {
						$lab = $value['labname'];
						$tat1 = $tat1+$value['tat1'];
						$tat2 = $tat2+$value['tat2'];
						$tat3 = $tat3+$value['tat3'];
						$tat4 = $tat4+$value['tat4'];
						$tat[$labname] = array(
									'lab' => $labname,
									'tat1' => $tat1,
									'tat2' => $tat2,
									'tat3' => $tat3,
									'tat4' => $tat4,
									'count' => $count
									);

						$count++;
					}
				
			}
			// echo "<pre>";print_r($tat);die();
			foreach ($tat as $key => $value) {
				$data[$key]['tat1'] = round($value['tat1']/$value['count']);
				$data[$key]['tat2'] = round(($value['tat2']/$value['count']) + $data[$key]['tat1']);
				$data[$key]['tat3'] = round(($value['tat3']/$value['count']) + $data[$key]['tat2']);
				$data[$key]['tat4'] = round($value['tat4']/$value['count']);
			}
		} else {
			echo "<pre>";print_r("NO TAT DATA FOUND FOR THE SELECTED PERIOD!");echo "</pre>";die();
		}
		
		// echo "<pre>";print_r($data);
		return $data;
	}

	function labs_outcomes($year=NULL,$month=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_lab_outcomes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

			$data['lab_outcomes'][0]['name'] = 'Not Suppressed';
			$data['lab_outcomes'][1]['name'] = 'Suppressed';

			$count = 0;
			
			$data["lab_outcomes"][0]["data"][0]	= $count;
			$data["lab_outcomes"][1]["data"][0]	= $count;
			$data['categories'][0]					= 'No Data';

			foreach ($result as $key => $value) {
				$data['categories'][$key] 					= $value['labname'];
				$data["lab_outcomes"][0]["data"][$key]	=  (int) $value['sustxfl'];
				$data["lab_outcomes"][1]["data"][$key]	=  (int) $value['detectableNless1000'];
			}
		
		// echo "<pre>";print_r($data);die();
		return $data;
	}
	
}
?>