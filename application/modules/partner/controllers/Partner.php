<?php
defined("BASEPATH") or exit();

/**
* 
*/
class Partner extends MY_Controller
{
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','tablecloth','select2')));
		$this->session->set_userdata('county_filter', NULL);
		$this->data['part'] = TRUE;
		$this->data['partner_select'] = $this->session->userdata('partner_filter');
	}

	public function index()
	{
		$this->load->module('charts/summaries');
		
		$this->data['content_view'] = 'partner/partner_summary_view';
		$this -> template($this->data);
	}

	public function nosuppression()
	{
		// echo "<pre>";print_r($this->session->all_userdata());die();
		$this->load->module('charts/nonsuppression');

		$this->data['content_view'] = 'partner/partner_no_suppression_view';
		$this -> template($this->data);
	}

	public function sites()
	{
		$this->load->module('charts/sites');

		$this->data['content_view'] = 'partner/partner_sites_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	public function get_selected_partner()
	{
		if ($this->session->userdata('partner_filter')) {
			$partner = $this->session->userdata('partner_filter');
		} else {
			$partner = 1;
		}
		 echo $partner;
	}

	public function check_partner_select()
	{
		if ($this->session->userdata('partner_filter')) {
			$partner = $this->session->userdata('partner_filter');
		} else {
			$partner = 0;
		}
		echo json_encode($partner);
	}
}
?>