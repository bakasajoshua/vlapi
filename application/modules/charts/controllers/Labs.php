<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Labs extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('labs_model');
	}

	function testing_trends($year=NULL)
	{
		$data['trends'] = $this->labs_model->lab_testing_trends($year);

		$this->load->view('labs_testing_trends',$data);
	}

	function rejection_trends($year=NULL)
	{
		$data['trends'] = $this->labs_model->lab_rejection_trends($year);
		// $data['trends'] = $this->lab_model->lab_rejection_trends($year);

		$this->load->view('labs_rejection_trends',$data);
	}

	function sample_types($year=NULL,$month=NULL)
	{
		$data['trends'] = $this->labs_model->sample_types($year,$month);

		$this->load->view('labs_sample_types',$data);
	}

	function turn_around_time($year=NULL,$month=NULL)
	{
		$data['trends'] = $this->labs_model->labs_turnaround($year,$month);

		$this->load->view('labs_turnaround_time',$data);
	}

	function results_outcome($year=NULL,$month=NULL)
	{
		$data['trends'] = $this->labs_model->labs_outcomes($year,$month);
		
		$this->load->view('lab_results_outcome', $data);
	}

	function display_date()
	{
		echo "(".$this->session->userdata('filter_year')." ".$this->labs_model->resolve_month($this->session->userdata('filter_month')).")";
	}

	function display_range()
	{
		echo "(".($this->session->userdata('filter_year')-1)." - ".$this->session->userdata('filter_year').")";
	}
}
?>