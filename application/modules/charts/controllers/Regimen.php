<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Regimen extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('regimen_model');
	}

	function regimen_outcomes($year=NULL,$month=NULL)
	{
		$data['outcomes']= $this->regimen_model->regimens_outcomes($year,$month);

		$this->load->view('county_outcomes_view', $data);
	}

	function regimen_vl_outcome($year=NULL,$month=NULL,$regimen=NULL)
	{
		$data['outcomes']= $this->regimen_model->regimen_vl_outcomes($year,$month,$regimen);

		$this->load->view('vl_outcomes_view',$data);
	}

	function regimen_gender($year=NULL,$month=NULL,$regimen=NULL)
	{
		$data['outcomes'] = $this->regimen_model->regimen_gender($year,$month,$regimen);
		
    	$this->load->view('gender_view',$data);
	}

	function regimen_age($year=NULL,$month=NULL,$regimen=NULL)
	{
		$data['outcomes'] = $this->regimen_model->regimen_age($year,$month,$regimen);
		
    	$this->load->view('agegroup_view',$data);
	}

	function sample_types($year=NULL,$regimen=NULL)
	{
		$data['outcomes'] = $this->regimen_model->regimen_samples($year,$regimen);

    	$this->load->view('sample_types_view',$data);
	}
}
?>