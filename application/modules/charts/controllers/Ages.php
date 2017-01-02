<?php
defined("BASEPATH") or exit();
/**
* 
*/
class Ages extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ages_model');
	}

	function age_outcomes($year=NULL,$month=NULL)
	{
		$data['outcomes']= $this->ages_model->ages_outcomes($year,$month);

		$this->load->view('county_outcomes_view', $data);
	}

	function age_vl_outcome($year=NULL,$month=NULL,$regimen=NULL)
	{
		$data['outcomes']= $this->ages_model->ages_vl_outcomes($year,$month,$regimen);

		$this->load->view('vl_outcomes_view',$data);
	}

	function age_gender($year=NULL,$month=NULL,$regimen=NULL)
	{
		$data['outcomes'] = $this->ages_model->ages_gender($year,$month,$regimen);
		
    	$this->load->view('gender_view',$data);
	}

	function sample_types($year=NULL,$regimen=NULL)
	{
		$data['outcomes'] = $this->ages_model->ages_samples($year,$regimen);

    	$this->load->view('sample_types_view',$data);
	}
}
?>