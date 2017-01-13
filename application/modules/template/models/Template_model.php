<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Template_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function get_counties_dropdown()
	{
		$dropdown = '';
		$county_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/county');

		foreach ($county_data['data'] as $key => $value) {
			$dropdown .= '<option value="'.$value['CountyMFLCode'].'">'.$value['CountyName'].' County</option>';
		}
		
		return $dropdown;
	}

	function get_county_name($county_id)
	{
		$county_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/county');

		foreach ($county_data['data'] as $key => $value) {
			if($value['CountyMFLCode'] == $county_id){
				return $value['CountyName'];
			}
		}

		
	}

	function get_partners_dropdown()
	{
		$dropdown = '';
		$partner_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/partner');

		foreach ($partner_data['data'] as $key => $value) {
			$dropdown .= '<option value="'.$value['PartnerId'].'">'.$value['PartnerName'].'</option>';
		}
		
		return $dropdown;
	}

	function get_site_dropdown()
	{
		$dropdown = '';
		// $site_data = $this->db->query('SELECT DISTINCT `view_facilitys`.`ID`, `view_facilitys`.`name` FROM `vl_site_summary` JOIN `view_facilitys` ON `vl_site_summary`.`facility` = `view_facilitys`.`ID`')->result_array();

		// foreach ($site_data as $key => $value) {
		// 	$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
		// }

		// $partner_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/partner');

		// foreach ($partner_data['data'] as $key => $value) {
		// 	$info = $this->req('https://api.nascop.org/vl/ver1.0/partner?partnerId='  . $value['PartnerId'] . '&aggregationPeriod=[201601]');
		// 	foreach($info['data'][0]['ListOfSupportedFacilities'] as $key2 => $value2){
		// 		$site = $this->req('https://api.nascop.org/vl/ver1.0/facility?mflCode=' .  $value2['MFLCode'] .'&aggregationPeriod=[201601]');
		// 		$dropdown .= '<option value="'.$value2['MFLCode'].'">'.
		// 		$site['data']['FacilityName'].'</option>';
		// 	}
		// }

		$county_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/county');

		foreach ($county_data['data'] as $key => $value) {
			$info = $this->req('https://api.nascop.org/vl/ver1.0/TopFacilities?entity=county&mflCode=' . $value['CountyMFLCode'] . '&aggregationPeriod=[201601]');
			foreach ($info['data'] as $key2 => $value2) {
				$dropdown .= '<option value="'.$value2['code'].'">'.
				$value2['name'].'</option>';
			}
		}


		return $dropdown;
	}

	function get_partner_name($partner_id)
	{
		$partner_data = $this->req('https://api.nascop.org/vl/ver1.0/admin/partner');

		foreach ($partner_data['data'] as $key => $value) {
			if($value['PartnerId'] == $partner_id){
				return $value['PartnerName'];
			}
		}
	}
}
?>