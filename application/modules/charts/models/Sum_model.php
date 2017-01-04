<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sum_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();
	}

	function set_period_param($year, $month){
		$param = '';
		$param .= $year;

		if($month){
			if($month < 10){
				$param .= '0' . $month;
			}
			else{
				$param .= $month;
			}
		}
		return $param;		
	}

	function turnaroundtime($year=null,$month=null,$county=null)
	{
		
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {

			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		
		$param = $this->set_period_param($year, $month);

		$information = $this->req('https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[' . $param . ']');
		$info = $information['data']['Period'];

		$data['tat1'] = 0;
		$data['tat2'] = 0;
		$data['tat3'] = 0;
		$data['tat4'] = 0;

		$count = 0;

		foreach ($info as $key => $value) {
			$data['tat1'] += $value['TestTAT']['CollectionToLabReceipt'];
			$data['tat2'] += $value['TestTAT']['LabReceiptToTesting'];
			$data['tat3'] += $value['TestTAT']['TestedToDispatch'];
			$data['tat4'] += $value['TestTAT']['CollectionToLabReceipt'] + $value['TestTAT']['LabReceiptToTesting'] + $value['TestTAT']['TestedToDispatch'];
			$count++;
		}

		$data['tat1'] = round((int) $data['tat1'] / $count);
		$data['tat2'] = round((int) $data['tat2'] / $count) + $data['tat1'];
		$data['tat3'] = round((int) $data['tat3'] / $count) + $data['tat2'];
		$data['tat4'] = round((int) $data['tat4'] / $count);
		
		echo "<pre>";print_r($data);die();
		return $data;
	}

	function county_outcomes($year=null,$month=null,$pfil=null,$partner=null,$county=null)
	{
		// echo "Year:".$year.":--: Month:".$month.":--: County:".$county.":--: Partner:".$partner.":--: pfil:".$pfil;die();
		//Initializing the value of the Year to the selected year or the default year which is current year
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		// Assigning the value of the county
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}
				
		// echo "PFil: ".$pfil." --Partner: ".$partner." -- County: ".$county;
		if ($county) {
			$sql = "CALL `proc_get_county_sites_outcomes`('".$county."','".$year."','".$month."')";
		} else {
			if ($pfil==1) {
				if ($partner) {
					$sql = "CALL `proc_get_partner_sites_outcomes`('".$partner."','".$year."','".$month."')";
				} else {
					$sql = "CALL `proc_get_partner_outcomes`('".$year."','".$month."')";
				}
				
			} else {
				$sql = "CALL `proc_get_county_outcomes`('".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);echo "</pre>";die();
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
		echo "<pre>";print_r($data);die();
		return $data;
	}

	function vl_outcomes($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
		}


		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$url;
		$param = $this->set_period_param($year, $month);

		if ($partner) {
			$url = 'https://api.nascop.org/vl/ver1.0/partner?partnerId=1&aggregationPeriod=[';
		} else {
			if ($county==null || $county=='null') {
				$url = 'https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[';
			} else {
				$url = 'https://api.nascop.org/vl/ver1.0/county?mflCode=40&dhisCode=wsBsC6gjHvn&aggregationPeriod=[';
			}
		}

		$url .= $param . "]";

		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = 'Suppresed';
		$data['vl_outcomes']['data'][1]['name'] = 'Not Suppresed';

		$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
		$data['vl_outcomes']['data'][1]['color'] = '#F2784B';

		$count = 0;

		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;

		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;

		
		$info = $this->req($url);

		if(!$month){
			$data['vl_outcomes']['data'][0]['y'] = 0;
			$data['vl_outcomes']['data'][1]['y'] = 0;

			foreach ($info['data']['Period'] as $key => $value) {
				$data['vl_outcomes']['data'][0]['y'] += $value['TestsDone']['Suppressed'];
				$data['vl_outcomes']['data'][1]['y'] += $value['TestsDone']['NonSuppressed'];
				
			}
		}
		else{
			$data['vl_outcomes']['data'][0]['y'] = $info['data']['Period'][0]['TestsDone']['Suppressed'];
			$data['vl_outcomes']['data'][1]['y'] = $info['data']['Period'][0]['TestsDone']['NonSuppressed'];
		}

		$greater = $data['vl_outcomes']['data'][1]['y'];
		$less = $data['vl_outcomes']['data'][0]['y'];
		$total = $greater + $total;

		$data['ul'] .= '<tr>
	    		<td colspan="2">Cumulative Tests (All Samples Run):</td>
	    		<td colspan="2">'.number_format($value['alltests']).'</td>
	    	</tr>
	    	<tr>
	    		<td colspan="2">&nbsp;&nbsp;&nbsp;Tests With Valid Outcomes:</td>
	    		<td colspan="2">'.number_format($total).'</td>
	    	</tr>

	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &gt; 1000 copies/ml:</td>
	    		<td>'.number_format($greater).'</td>
	    		<td>Percentage Non Suppression</td>
	    		<td>'.(int) (($greater/$total)*100).'%</td>
	    	</tr>

	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &lt; 1000 copies/ml:</td>
	    		<td>'.number_format($less).'</td>
	    		<td>Percentage Suppression</td>
	    		<td>'.(int) (($less/$total)*100).'%</td>
	    	</tr>

	    	<tr>
	    		<td></td>
	    		<td></td>
	    		<td></td>
	    		<td></td>
	    	</tr>

	    	<tr>
	    		<td>Confirmatory Repeat Tests:</td>
	    		<td>'.number_format($value['confirmtx']).'</td>
	    		<td>Non Suppression ( &gt; 1000cpml)</td>
	    		<td>'.number_format($value['confirm2vl']). ' (' .round(($value['confirm2vl'] * 100 / $value['confirmtx']), 2). '%)' .'</td>
	    	</tr>

	    	<tr>
	    		<td>Rejected Samples:</td>
	    		<td>'.number_format($value['rejected']).'</td>
	    		<td>Percentage Rejection Rate</td>
	    		<td>'. round((($value['rejected']*100)/$value['received']), 2, PHP_ROUND_HALF_UP).'%</td>
	    	</tr>';

		echo "<pre>";print_r($data);die();
		return $data;
	}

	function justification($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$param = $this->set_period_param($year, $month);

		$information;

		if ($partner) {

			$information = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $partner . '&aggregationPeriod=[' . $param . ']');

		} 
		if(!$partner){
			if ($county==null || $county=='null') {

				$information = $this->req('https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[' . $param . ']');
			} 
			else {
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?dhisCode=' . $county . '&aggregationPeriod=[' . $param . ']');
			}
		}

		//echo "<pre>";print_r($information);die();
		//return $result;

		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;		

		$data['justification']['data'][0]['name'] = 'Routine VL';
		$data['justification']['data'][0]['color'] = '#5C97BF';

		$data['justification']['data'][1]['name'] = 'Baseline';

		$data['justification']['data'][2]['name'] = 'Clinical Failure';

		$data['justification']['data'][3]['name'] = 'Confirmation of Treatment Failure (Repeat VL at 3M)';

		$data['justification']['data'][4]['name'] = 'Immunological Failure';

		$data['justification']['data'][5]['name'] = 'Lactating Mothers';

		$data['justification']['data'][6]['name'] = 'No Data';

		$data['justification']['data'][7]['name'] = 'Pregnant Mother';

		$data['justification']['data'][8]['name'] = 'Single Drug Substitution';

		
		$count = 0;
		$data['justification']['data'][0]['y'] = 0;
		$data['justification']['data'][1]['y'] = 0;
		$data['justification']['data'][2]['y'] = 0;
		$data['justification']['data'][3]['y'] = 0;
		$data['justification']['data'][4]['y'] = 0;
		$data['justification']['data'][5]['y'] = 0;
		$data['justification']['data'][6]['y'] = 0;
		$data['justification']['data'][7]['y'] = 0;
		$data['justification']['data'][8]['y'] = 0;

		foreach ($information['data']['Period'] as $key => $value) {
			$data['justification']['data'][0]['y'] += $value['TestJustification']['RoutineTestingTotalTests'];
			$data['justification']['data'][1]['y'] += $value['TestJustification']['BaselineTestingTotalTests'];
			$data['justification']['data'][2]['y'] += $value['TestJustification']['ClinicalFailureTotalTests'];
			$data['justification']['data'][3]['y'] += $value['TestJustification']['ConfirmationOfTreatementFailureTotalTests'];
			$data['justification']['data'][4]['y'] += $value['TestJustification']['ImmunologicalFailureTotalTests'];
			$data['justification']['data'][5]['y'] += $value['TestJustification']['LactatingMotherTotalTests'];
			$data['justification']['data'][6]['y'] += $value['TestJustification']['NoDataTotalTests'];
			$data['justification']['data'][7]['y'] += $value['TestJustification']['PregnantMotherTotalTests'];
			$data['justification']['data'][8]['y'] += $value['TestJustification']['DrugSubstitutionTotalTests'];
			$count++;

		}

		// $data['justification']['data'][0]['y'] = round($data['justification']['data'][0]['y'] / $count);
		// $data['justification']['data'][1]['y'] = round($data['justification']['data'][1]['y'] / $count);
		// $data['justification']['data'][2]['y'] = round($data['justification']['data'][2]['y'] / $count);
		// $data['justification']['data'][3]['y'] = round($data['justification']['data'][3]['y'] / $count);
		// $data['justification']['data'][4]['y'] = round($data['justification']['data'][4]['y'] / $count);
		// $data['justification']['data'][5]['y'] = round($data['justification']['data'][5]['y'] / $count);
		// $data['justification']['data'][6]['y'] = round($data['justification']['data'][6]['y'] / $count); 
		// $data['justification']['data'][7]['y'] = round($data['justification']['data'][7]['y'] / $count);
		// $data['justification']['data'][8]['y'] = round($data['justification']['data'][8]['y'] / $count);

		

		$data['justification']['data'][1]['sliced'] = true;
		$data['justification']['data'][1]['selected'] = true;
		echo "<pre>";print_r($data);die();
		return $data;
	}

	function justification_breakdown($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		

		$param = $this->set_period_param($year, $month);

		$information;

		if ($partner) {

			$information = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $partner . '&aggregationPeriod=[' . $param . ']');

		} 
		else{
			if ($county==null || $county=='null') {

				$information = $this->req('https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[' . $param . ']');
			} 
			else {
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?dhisCode=' . $county . '&aggregationPeriod=[' . $param . ']');
			}
		}
		// echo "<pre>";print_r($sql);
		// echo "<pre>";print_r($sql2);die();
		
		
		$data['just_breakdown'][0]['name'] = 'Not Suppresed';
		$data['just_breakdown'][1]['name'] = 'Suppresed';

		$count = 0;

		$data['categories'][0] 			= 'Pregnant Mothers';
		$data["just_breakdown"][0]["data"][0]	=  0;
		$data["just_breakdown"][1]["data"][0]	=  0;
	
		$data['categories'][1] 			= 'Lactating Mothers';
		$data["just_breakdown"][0]["data"][1]	=  0;
		$data["just_breakdown"][1]["data"][1]	=  0;

		foreach ($information['data']['Period'] as $key => $value) {

			$data["just_breakdown"][0]["data"][0] +=  $value['TestJustification']['PregnantMotherNonSuppressed'];
			$data["just_breakdown"][1]["data"][0] +=  $value['TestJustification']['PregnantMotherSuppressed'];
			$data["just_breakdown"][0]["data"][1] +=  $value['TestJustification']['LactatingMotherNonSuppressed'];
			$data["just_breakdown"][1]["data"][1] +=  $value['TestJustification']['LactatingMotherSuppressed'];

		}
		
		$data['just_breakdown'][0]['drilldown']['color'] = '#913D88';
		$data['just_breakdown'][1]['drilldown']['color'] = '#96281B';
		echo "<pre>";print_r($data);die();
		return $data;
	}

	function age($year=null,$month=null,$county=null,$partner=null)
	{
		
		

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
		}

		$param = '';
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		$param .= $year;
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if($month){
			if($month < 10){
				$param .= '0' . $month;
			}
			else{
				$param .= $month;
			}
		}

		if ($partner) {

			$information = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $partner . '&aggregationPeriod=[' . $param . ']');

		} 
		if(!$partner){
			if ($county==null || $county=='null') {

				$information = $this->req('https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[' . $param . ']');
			} 
			else {
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?dhisCode=' . $county . '&aggregationPeriod=[' . $param . ']');
			}
		}

		
		//echo "<pre>";print_r($information);die();
		$data['ageGnd'][0]['name'] = 'Not Suppresed';
		$data['ageGnd'][1]['name'] = 'Suppresed';

		
		$data["ageGnd"][0]["data"][0]	= 0;
		$data["ageGnd"][1]["data"][0]	= 0;
		$data['categories'][0]			= '';
		$data['categories'][1]			= 'Less 2';
		$data['categories'][2]			= '2-9';
		$data['categories'][3]			= '10-14';
		$data['categories'][4]			= '15-19';
		$data['categories'][5]			= '20-24';
		$data['categories'][6]			= '25+';

		$data["ageGnd"][0]["data"][1] = 0;
		$data["ageGnd"][0]["data"][2] = 0;
		$data["ageGnd"][0]["data"][3] = 0;
		$data["ageGnd"][0]["data"][4] = 0;
		$data["ageGnd"][0]["data"][5] = 0;
		$data["ageGnd"][0]["data"][6] = 0;

		$data["ageGnd"][1]["data"][1] = 0;
		$data["ageGnd"][1]["data"][2] = 0;
		$data["ageGnd"][1]["data"][3] = 0;
		$data["ageGnd"][1]["data"][4] = 0;
		$data["ageGnd"][1]["data"][5] = 0;
		$data["ageGnd"][1]["data"][6] = 0;

		$count = 0;

		foreach ($information['data']['Period'] as $value) {
			$result = $value['Results']['TotalByAge'];
			$data["ageGnd"][0]["data"][1] += $result['NonSuppressedBelowAge2'];
			$data["ageGnd"][0]["data"][2] += $result['NonSuppressedBelowAge10'];
			$data["ageGnd"][0]["data"][3] += $result['NonSuppressedBelowAge15'];
			$data["ageGnd"][0]["data"][4] += $result['NonSuppressedBelowAge20'];
			$data["ageGnd"][0]["data"][5] += $result['NonSuppressedAboveAge25'];
			$data["ageGnd"][0]["data"][6] += $result['NonSuppressedNoAge'];

			$data["ageGnd"][1]["data"][1] += $result['SupressedBelowAge2'];
			$data["ageGnd"][1]["data"][2] += $result['SupressedBelowAge10'];
			$data["ageGnd"][1]["data"][3] += $result['SupressedBelowAge15'];
			$data["ageGnd"][1]["data"][4] += $result['SupressedBelowAge20'];
			$data["ageGnd"][1]["data"][5] += $result['SupressedAboveAge25'];
			$data["ageGnd"][1]["data"][6] += $result['SupressedNoAge'];

			//echo "<pre>";print_r($result);
			
			$count++;
		}
		//die();

		// $data["ageGnd"][0]["data"][1] = round($data["ageGnd"][0]["data"][1] / $count);
		// $data["ageGnd"][0]["data"][2] = round($data["ageGnd"][0]["data"][2] / $count);
		// $data["ageGnd"][0]["data"][3] = round($data["ageGnd"][0]["data"][3] / $count);
		// $data["ageGnd"][0]["data"][4] = round($data["ageGnd"][0]["data"][4] / $count);
		// $data["ageGnd"][0]["data"][5] = round($data["ageGnd"][0]["data"][5] / $count);
		// $data["ageGnd"][0]["data"][6] = round($data["ageGnd"][0]["data"][6] / $count);

		// $data["ageGnd"][1]["data"][1] = round($data["ageGnd"][1]["data"][1] / $count);
		// $data["ageGnd"][1]["data"][2] = round($data["ageGnd"][1]["data"][2] / $count);
		// $data["ageGnd"][1]["data"][3] = round($data["ageGnd"][1]["data"][3] / $count);
		// $data["ageGnd"][1]["data"][4] = round($data["ageGnd"][1]["data"][4] / $count);
		// $data["ageGnd"][1]["data"][5] = round($data["ageGnd"][1]["data"][5] / $count);
		// $data["ageGnd"][1]["data"][6] = round($data["ageGnd"][1]["data"][6] / $count);

		
		

		// die();
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';

		// echo "<pre>";print_r($data);die();
		$data['categories'] = array_values($data['categories']);
		$data["ageGnd"][0]["data"] = array_values($data["ageGnd"][0]["data"]);
		$data["ageGnd"][1]["data"] = array_values($data["ageGnd"][1]["data"]);
		echo "<pre>";print_r($data);die();
		return $data;
	}

	function age_breakdown($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
		}

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

		if ($partner) {
			$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_age`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_regional_age`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['children']['name'] = 'Tests';
		$data['children']['colorByPoint'] = true;

		$data['adults']['name'] = 'Tests';
		$data['adults']['colorByPoint'] = true;
		$adults = 0;
		$sadult = 0;
		$children = 0;
		$schildren = 0;
		$count = 0;

		foreach ($result as $key => $value) {
			
			if ($value['name']=='Less 2' || $value['name']=='2-9' || $value['name']=='10-14') {
				$data['ul']['children'] = '';
				$children = (int) $children + (int) $value['agegroups'];
				$schildren = (int) $schildren + (int) $value['suppressed'];
				$data['children']['data'][$key]['y'] = $count;
				$data['children']['data'][$key]['name'] = $value['name'];
				$data['children']['data'][$key]['y'] = (int) $value['agegroups'];

			} else if ($value['name']=='15-19' || $value['name']=='20-24' || $value['name']=='25+') {
				$data['ul']['adults'] = '';
				$adults = (int) $adults + (int) $value['agegroups'];
				$sadult = (int) $sadult + (int) $value['suppressed'];
				$data['adults']['data'][$key]['y'] = $count;
				$data['adults']['data'][$key]['name'] = $value['name'];
				$data['adults']['data'][$key]['y'] = (int) $value['agegroups'];
			}
		}
		// echo "<pre>";print_r($schildren);echo "</pre>";
		// echo "<pre>";print_r($data);
		$data['ctotal'] = $children;
		$data['atotal'] = $adults;
		
		$data['ul']['children'] = '<li>Children Suppression : '.(int)(((int) $schildren/(int) $children)*100).'%</li>';
		$data['ul']['adults'] = '<li>Adult Suppression : '.(int)(((int) $sadult/(int) $adults)*100).'%</li>';
		$data['children']['data'] = array_values($data['children']['data']);
		$data['adults']['data'] = array_values($data['adults']['data']);

		$data['children']['data'][0]['sliced'] = true;
		$data['children']['data'][0]['selected'] = true;

		$data['adults']['data'][0]['sliced'] = true;
		$data['adults']['data'][0]['selected'] = true;

		echo "<pre>";print_r($data);die();
		
		return $data;
	}

	// Not Possible
	function gender($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

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

		if ($partner) {
			$sql = "CALL `proc_get_partner_gender`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_gender`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_regional_gender`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['gender'][0]['name'] = 'Not Suppresed';
		$data['gender'][1]['name'] = 'Suppresed';

		$count = 0;
		
		$data["gender"][0]["data"][0]	= $count;
		$data["gender"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 			= $value['name'];
			$data["gender"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["gender"][1]["data"][$key]	=  (int) $value['suppressed'];
		}

		$data['gender'][0]['drilldown']['color'] = '#913D88';
		$data['gender'][1]['drilldown']['color'] = '#96281B';
		echo "<pre>";print_r($data);die();
		return $data;
	}

	function sample_types($year=null,$county=null,$partner=null)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;

		if ($partner) {

			$information = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $partner . '&aggregationPeriod=[' . $from . ']');
			$information2 = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $partner . '&aggregationPeriod=[' . $to . ']');

		} else {
			if ($county==null || $county=='null') {

				$information = $this->req('https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[' . $from . ']');
				$information2 = $this->req('https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[' . $to . ']');
			} 
			else {
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?dhisCode=' . $county . '&aggregationPeriod=[' . $from . ']');
				$information2 = $this->req('https://api.nascop.org/vl/ver1.0/county?dhisCode=' . $county . '&aggregationPeriod=[' . $to . ']');
			}
		}
		


		$result = array_merge($information['data']['Period'], $information2['data']['Period']);
		// echo "<pre>";print_r($result);die();
		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;

		foreach ($result as $key => $value) {
			$period = $value->period;
			$times = str_split($period, 4);
			
			$data['categories'][$key] = $this->resolve_month((int)$times[1]).'-'.$times[0];

			$data["sample_types"][0]["data"][$key]	= (int) $value['SampleTypes']['EDTA'];
			$data["sample_types"][1]["data"][$key]	= (int) $value['SampleTypes']['DBS'];
			$data["sample_types"][2]["data"][$key]	= (int) $value['SampleTypes']['FrozenPlasma'];
			
		}
		//echo "<pre>";print_r($data);die();
		return $data;
	}

	

}
?>