<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Partner_trends extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('partner_trend_api_model');
	}

	function positive_trends($partner=NULL){
		$obj = $this->partner_trend_api_model->yearly_trends($partner);
		echo "<pre>";print_r($obj);echo "</pre>";die();

		$data['trends'] = $obj['suppression_trends'];
		$data['title'] = "Suppression Trends";
		$data['div_name'] = "suppression";
		$data['suffix'] = "%";
		$data['yAxis'] = "Suppression Rate (%)";
		$this->load->view('yearly_trends_view', $data);

		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Testing Trends";
		$data['div_name'] = "tests";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of  Valid Tests";
		$this->load->view('yearly_trends_view', $data);

		

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejection Rate Trends";
		$data['div_name'] = "rejects";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";
		$this->load->view('yearly_trends_view', $data);


		$data['trends'] = $obj['tat_trends'];
		$data['title'] = "Collection - Dispatch";
		$data['div_name'] = "tat";
		$data['suffix'] = "";
		$data['yAxis'] = "TAT(Days)";
		$this->load->view('yearly_trends_view', $data);

		

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}

	function summary($partner=NULL){
		$data['trends'] = $this->partner_trend_api_model->yearly_summary($partner);
		//$data['trends'] = $this->positivity_model->yearly_summary();
		//echo json_encode($data);
		echo "<pre>";print_r($data);die();
		$this->load->view('trends_outcomes_view', $data);
	}


}