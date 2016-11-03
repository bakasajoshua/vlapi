<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Sites extends MY_Controller
{
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2')));
		$this->data['sit'] = TRUE;
		$this->load->module('charts/sites');
	}

	function index()
	{
		$this->data['content_view'] = 'sites/sites_view';
		$this -> template($this->data);
	}

	public function check_site_select()
	{
		if ($this->session->userdata('site_filter')) {
			$site = $this->session->userdata('site_filter');
		} else {
			$site = 0;
		}
		echo json_encode($site);
	}
}
?>