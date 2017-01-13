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
				$month = '';
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
		
		//echo "<pre>";print_r($data);die();
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
				$month = '';
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

		$param = $this->set_period_param($year, $month);

		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

				
		// echo "PFil: ".$pfil." --Partner: ".$partner." -- County: ".$county;
		if ($county) {
			// $sql = "CALL `proc_get_county_sites_outcomes`('".$county."','".$year."','".$month."')";
			$data = $this->get_county_sites_outcomes($param, $county);
		} else {
			if ($pfil==1) {
				if ($partner) {
					// $sql = "CALL `proc_get_partner_sites_outcomes`('".$partner."','".$year."','".$month."')";
					$data = $this->get_partner_sites_outcomes($param, $partner);
				} else {
					// $sql = "CALL `proc_get_partner_outcomes`('".$year."','".$month."')";
					$data = $this->get_partners_outcomes($param);
				}
				
			} else {
				$data = $this->get_county_outcomes($param);
			}
		}
		// echo "<pre>";print_r($data);die();
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
				$month = '';
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$url;
		$param = $this->set_period_param($year, $month);

		if ($partner) {
			$url = 'https://api.nascop.org/vl/ver1.0/partner?partnerId=' . $partner . '&aggregationPeriod=[';
		} else {
			if ($county==null || $county=='null') {
				$url = 'https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[';
			} else {
				$url = 'https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[';
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

		
		$information = $this->req($url);

		$result;
		if($county || $partner){
			$result = $information['data'][0]['Period'];
		}
		else{
			$result = $information['data']['Period'];
		}

		$data['vl_outcomes']['data'][0]['y'] = 0;
		$data['vl_outcomes']['data'][1]['y'] = 0;

		$rejected = 0;
		$ctf = 0;
		$tests = 0;
		$tr = 0;

		foreach ($result as $key => $value) {
			$data['vl_outcomes']['data'][0]['y'] += $value['TestsDone']['Suppressed'];
			$data['vl_outcomes']['data'][1]['y'] += $value['TestsDone']['NonSuppressed'];

			$rejected += $value['TestsDone']['Rejected'];
			$ctf += $value['TestsDone']['ConfirmedTreatmentFailure'];
			$tests += $value['TestsDone']['TotalTests'];
			$tr += $value['TestsDone']['TotalRepeatSamples'];
		}

		$greater = $data['vl_outcomes']['data'][1]['y'];
		$less = $data['vl_outcomes']['data'][0]['y'];
		$total = $greater + $less;

		

		$data['ul'] .= '<tr>
	    		<td colspan="2">Cumulative Tests (All Samples Run):</td>
	    		<td colspan="2">'.number_format($tests).'</td>
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
	    		<td>Rejected Samples:</td>
	    		<td>'.number_format($rejected).'</td>
	    		<td>Percentage Rejection Rate</td>
	    		<td>'. round((($rejected*100)/$total), 2, PHP_ROUND_HALF_UP).'%</td>
	    	</tr>';



		//echo "<pre>";print_r($data);die();
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
				$month = '';
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
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[' . $param . ']');
			}
		}

		$result;
		if($county || $partner){
			$result = $information['data'][0]['Period'];
		}
		else{
			$result = $information['data']['Period'];
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

		foreach ($result as $key => $value) {
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

		$data['justification']['data'][1]['sliced'] = true;
		$data['justification']['data'][1]['selected'] = true;
		//echo "<pre>";print_r($data);die();
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
				$month = '';
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
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[' . $param . ']');
			}
		}

		$result;
		if($county || $partner){
			$result = $information['data'][0]['Period'];
		}
		else{
			$result = $information['data']['Period'];
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

		foreach ($result as $key => $value) {

			$data["just_breakdown"][0]["data"][0] +=  $value['TestJustification']['PregnantMotherNonSuppressed'];
			$data["just_breakdown"][1]["data"][0] +=  $value['TestJustification']['PregnantMotherSuppressed'];
			$data["just_breakdown"][0]["data"][1] +=  $value['TestJustification']['LactatingMotherNonSuppressed'];
			$data["just_breakdown"][1]["data"][1] +=  $value['TestJustification']['LactatingMotherSuppressed'];

		}
		
		$data['just_breakdown'][0]['drilldown']['color'] = '#913D88';
		$data['just_breakdown'][1]['drilldown']['color'] = '#96281B';
		//echo "<pre>";print_r($data);die();
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
				$month = '';
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
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[' . $param . ']');
			}
		}

		$result;
		if($county || $partner){
			$result = $information['data'][0]['Period'];
		}
		else{
			$result = $information['data']['Period'];
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

		foreach ($result as $value) {
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
		
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';

		// echo "<pre>";print_r($data);die();
		$data['categories'] = array_values($data['categories']);
		$data["ageGnd"][0]["data"] = array_values($data["ageGnd"][0]["data"]);
		$data["ageGnd"][1]["data"] = array_values($data["ageGnd"][1]["data"]);

		// echo "<pre>";print_r($data);die();
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
				$month = '';
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$param = $this->set_period_param($year, $month);

		$information;
		$periods;

		if ($partner) {

			$information = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $partner . '&aggregationPeriod=[' . $param . ']');
			$periods = $information['data'][0]['Period'];

		} 
		else{
			if ($county==null || $county=='null') {
				$information = $this->req('https://api.nascop.org/vl/ver1.0/national?aggregationPeriod=[' . $param . ']');
				$periods = $information['data']['Period'];
			} 
			else {
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[' . $param . ']');
				$periods = $information['data'][0]['Period'];
			}
		}

		
		//echo "<pre>";print_r($information);die();

		$data['children']['name'] = 'Tests';
		$data['children']['colorByPoint'] = true;

		$data['adults']['name'] = 'Tests';
		$data['adults']['colorByPoint'] = true;
		$adults = 0;
		$sadult = 0;
		$children = 0;
		$schildren = 0;
		$count = 0;

		$data['children']['data'][0]['y'] = 0;
		$data['children']['data'][1]['y'] = 0;
		$data['children']['data'][2]['y'] = 0;

		$data['adults']['data'][0]['y'] = 0;
		$data['adults']['data'][1]['y'] = 0;

		foreach ($periods as $key => $value) {
			$result = $value['Results']['TotalByAge'];

			$data['children']['data'][0]['name'] = 'Less 2';
			$data['children']['data'][0]['y'] += (int) $result['NonSuppressedBelowAge2'] + (int) $result['SupressedBelowAge2'];
			$data['children']['data'][1]['name'] = '2-9';
			$data['children']['data'][1]['y'] += (int) $result['NonSuppressedBelowAge10'] + (int) $result['SupressedBelowAge10'];
			$data['children']['data'][2]['name'] = '10-14';
			$data['children']['data'][2]['y'] += (int) $result['NonSuppressedBelowAge15'] + (int) $result['SupressedBelowAge15'];

			$schildren_ = (int) $result['SupressedBelowAge2'] + (int) $result['SupressedBelowAge10'] + (int) $result['SupressedBelowAge15'];

			$children_ = $schildren_ + (int) $result['NonSuppressedBelowAge2'] + (int) $result['NonSuppressedBelowAge10'] + (int) $result['NonSuppressedBelowAge15'];

			$schildren += $schildren_;
			$children += $children_;


			$data['adults']['data'][0]['name'] = '15-19';
			$data['adults']['data'][0]['y'] += (int) $result['NonSuppressedBelowAge20'] + (int) $result['SupressedBelowAge20'];
			$data['adults']['data'][1]['name'] = '25+';
			$data['adults']['data'][1]['y'] += (int) $result['NonSuppressedAboveAge25'] + (int) $result['SupressedAboveAge25'];

			$sadult_ = (int) $result['SupressedAboveAge25'] + (int) $result['SupressedBelowAge20'];
			$adult_ = $sadult_ + (int) $result['NonSuppressedBelowAge20'] + (int) $result['NonSuppressedAboveAge25'];

			$sadult += $sadult_;
			$adults += $adult_;


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

		// echo "<pre>";print_r($data);die();
		
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
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	// Not Possible Any More
	function sample_types($year=null,$county=null,$partner=null)
	{
		/*$array1 = array();
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
				$information = $this->req('https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[' . $from . ']');
				$information2 = $this->req('https://api.nascop.org/vl/ver1.0/county?mflCode=' . $county . '&aggregationPeriod=[' . $to . ']');
			}
		}

		//echo "<pre>";print_r($information);die();
		
		$result;
		if($county || $partner){
			$result = array_merge($information['data'][0]['Period'], $information2['data'][0]['Period']);
		}
		else{
			$result = array_merge($information['data']['Period'], $information2['data']['Period']);
		}
		
		//echo "<pre>";print_r($result);die();
		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;

		foreach ($result as $key => $value) {
			$period = $value['period'];
			$times = str_split($period, 4);
			
			$data['categories'][$key] = $this->resolve_month((int)$times[1]).'-'.$times[0];

			$data["sample_types"][0]["data"][$key]	= (int) $value['SampleTypes']['EDTA'];
			$data["sample_types"][1]["data"][$key]	= (int) $value['SampleTypes']['DBS'];
			$data["sample_types"][2]["data"][$key]	= (int) $value['SampleTypes']['FrozenPlasma'];
			
		}*/
		$data = '';
		//echo "<pre>";print_r($data);die();
		return $data;
	}

	function get_county_outcomes($param){
		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$county_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/county');
		$size = count($county_data['data']);
		//echo "<pre>";print_r($size);echo "</pre>";die();
		$data["county_outcomes"][0]["data"] = array_fill(0, $size, 0);
		$data["county_outcomes"][1]["data"] = array_fill(0, $size, 0);

		foreach ($county_data['data'] as $key => $value) {

			$information = $this->req('https://api.nascop.org/vl/ver1.0/county?mflCode=' . $value['CountyMFLCode'] . '&aggregationPeriod=[' . $param . ']');

			$data['categories'][$key] = $value['CountyName'];

			foreach ($information['data'][0]['Period'] as $key2 => $value2) {
				$data["county_outcomes"][0]["data"][$key] += $value2['TestsDone']['NonSuppressed'];
				$data["county_outcomes"][1]["data"][$key] += $value2['TestsDone']['Suppressed'];

				// echo "<pre>";print_r($data);echo "</pre>";die();
			}
		}
		
		return $data;
	}

	function get_partners_outcomes($param){
		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$partner_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/partner');
		$size = count($partner_data['data']) - 1;

		$data["county_outcomes"][0]["data"] = array_fill(0, $size, 0);
		$data["county_outcomes"][1]["data"] = array_fill(0, $size, 0);

		$count = 0;

		foreach ($partner_data['data'] as $key => $value) {

			if($value['PartnerId'] != 0){
				$information = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $value['PartnerId'] . '&aggregationPeriod=[' . $param . ']');

				//echo "<pre>";print_r($information);echo "</pre>";die();
			
				$data['categories'][$count] = $value['PartnerName'];

				foreach ($information['data'][0]['Period'] as $key2 => $value2) {
					$data["county_outcomes"][0]["data"][$count] += $value2['TestsDone']['NonSuppressed'];
					$data["county_outcomes"][1]["data"][$count] += $value2['TestsDone']['Suppressed'];

					// echo "<pre>";print_r($data);echo "</pre>";die();
				}
				$count++;
			}

		}
		
		return $data;
	}

	function get_partner_sites_outcomes($param, $partner){
		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$partner_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/partner');
		//echo "<pre>";print_r($partner_data);echo "</pre>";die();
		
		$information = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $partner . '&aggregationPeriod=[201601]');

		$supported = $information['data'][0]['ListOfSupportedFacilities'];

		$size = count($supported);

		$data["county_outcomes"][0]["data"] = array_fill(0, $size, 0);
		$data["county_outcomes"][1]["data"] = array_fill(0, $size, 0);

		foreach($supported as $key => $value){
			$site = $this->req('https://api.nascop.org/vl/ver1.0/facility?mflCode=' .  $value['MFLCode'] .'&aggregationPeriod=['. $param . ']');
			$data['categories'][$key] = $value['MFLCode'];

			foreach ($site['data'][0]['Period'] as $key2 => $value2) {
				$data["county_outcomes"][0]["data"][$key] += $value2['TestsDone']['NonSuppressed'];
				$data["county_outcomes"][1]["data"][$key] += $value2['TestsDone']['Suppressed'];
			}

		}

		
		return $data;
	}

	function get_county_sites_outcomes($param, $county){
		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$info = $this->req('https://api.nascop.org/vl/ver1.0/TopFacilities?entity=county&mflCode=' . $county . '&aggregationPeriod=[' . $param . ']');

		$size = count($info['data']);
		
		foreach ($info['data'] as $key => $value) {
			
			$data['categories'][$key] = $value['name'];

			$data["county_outcomes"][0]["data"][$key] = $value['nonsuppressed'];
			$data["county_outcomes"][1]["data"][$key] = $value['suppressed'];

		}

		return $data;
	}

	

}
?>