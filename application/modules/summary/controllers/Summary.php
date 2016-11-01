<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends MY_Controller {

	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','select2')));
		$this->session->set_userdata('partner_filter', NULL);
		$this->load->module('charts/summaries');
	}

	public function index()
	{
		$this->data['content_view'] = 'summary/summary_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}
}