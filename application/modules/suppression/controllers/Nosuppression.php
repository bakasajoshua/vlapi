<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Nosuppression extends MY_Controller
{
	
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','select2')));
		$this->session->set_userdata('partner_filter', NULL);
		$this->load->module('charts/nonsuppression');
	}

	public function index()
	{
		$this->data['content_view'] = 'suppression/nosuppression_view';
		$this -> template($this->data);
	}
}
?>