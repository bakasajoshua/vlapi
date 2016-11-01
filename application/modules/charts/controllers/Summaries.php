<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summaries extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->load->model('summaries_model');
	}

	function turnaroundtime($year=NULL,$month=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->turnaroundtime($year,$month,$county);

		$this->load->view('turnaroundtime_view',$data);
	}
	
	function county_outcomes($year=NULL,$month=NULL,$pfil=NULL,$partner=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->county_outcomes($year,$month,$pfil,$partner,$county);

    	$this->load->view('county_outcomes_view',$data);
	}

	function vl_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->vl_outcomes($year,$month,$county,$partner);

    	$this->load->view('vl_outcomes_view',$data);
	}

	function justification($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->justification($year,$month,$county,$partner);

    	$this->load->view('justification_view',$data);
	}

	function justificationbreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->justification_breakdown($year,$month,$county,$partner);
		
		$this->load->view('justification_breakdown_view',$data);
	}

	function age($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->age($year,$month,$county,$partner);
		
    	$this->load->view('agegroup_view',$data);
	}

	function agebreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->age_breakdown($year,$month,$county,$partner);
		
		$this->load->view('agegroupBreakdown',$data);
	}

	function gender($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->gender($year,$month,$county,$partner);

    	$this->load->view('gender_view',$data);
	}

	function sample_types($year=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->sample_types($year,$county,$partner);

    	$this->load->view('sample_types_view',$data);
	}

	function display_date()
	{
		echo "(".$this->session->userdata('filter_year')." ".$this->summaries_model->resolve_month($this->session->userdata('filter_month')).")";
	}

	function display_range()
	{
		echo "(".($this->session->userdata('filter_year')-1)." - ".$this->session->userdata('filter_year').")";
	}

}
?>