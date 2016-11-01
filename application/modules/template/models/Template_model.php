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
		$county_data = $this->db->get('countys')->result_array();

		foreach ($county_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].' County</option>';
		}
		
		return $dropdown;
	}

	function get_county_name($county_id)
	{
		$this->db->where('ID', $county_id);
		$data = $this->db->get('countys')->result_array();
		$name = $data[0]["name"];

		return $name;
	}

	function get_partners_dropdown()
	{
		$dropdown = '';
		$partner_data = $this->db->query('SELECT `ID`, `name` FROM `partners` ORDER BY `name` ASC')->result_array();

		foreach ($partner_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
		}
		
		return $dropdown;
	}

	function get_site_dropdown()
	{
		$dropdown = '';
		$site_data = $this->db->query('SELECT DISTINCT `view_facilitys`.`ID`, `view_facilitys`.`name` FROM `vl_site_summary` JOIN `view_facilitys` ON `vl_site_summary`.`facility` = `view_facilitys`.`ID`')->result_array();

		foreach ($site_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
		}

		return $dropdown;
	}

	function get_partner_name($partner_id)
	{
		$this->db->where('ID', $partner_id);
		$data = $this->db->get('partners')->result_array();
		$name = $data[0]["name"];

		return $name;
	}
}
?>