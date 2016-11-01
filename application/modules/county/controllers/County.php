<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class County extends MY_Controller {
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom', 'Kenya', 'tablecloth')));
		$this->session->set_userdata('partner_filter', NULL);
		$this->load->module('charts/counties');
	}

	function index()
	{
		$this->data['county'] = TRUE;
		$this->data['content_view'] = 'county/county_map';
		$this -> template($this->data);
	}
}

?>

