<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Nonsuppression extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('nonsuppression_model');
	}

	function notification ($year=NULL,$month=NULL,$county=NULL)
	{
		$data['suppressions'] = $this->nonsuppression_model->notification_bar($year,$month,$county);

		$this->load->view('sup_notification_view',$data);
	}

	function gender_group($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['suppressions'] = $this->nonsuppression_model->gender_group_chart($year,$month,$county,$partner);

    	$this->load->view('sup_gender_group_view',$data);
	}

	function age_group($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['suppressions'] = $this->nonsuppression_model->age_group_chart($year,$month,$county,$partner);

    	$this->load->view('sup_age_group_view',$data);
	}

	function justification($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['suppressions'] = $this->nonsuppression_model->justifications($year,$month,$county,$partner);

    	$this->load->view('sup_justification_view',$data);
	}
	function regimen($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['suppressions'] = $this->nonsuppression_model->regimen($year,$month,$county,$partner);

    	$this->load->view('sup_regimen_view',$data);
	}

	function sample_type($year=NULL,$month=NULL,$county=NULL,$partner=NULL)
	{
		$data['suppressions'] = $this->nonsuppression_model->sampletypes($year,$month,$county,$partner);

    	$this->load->view('sup_sampleTypes_view',$data);
	}

	function county_listings($year=NULL,$month=NULL)
	{
		$data['countys'] = $this->nonsuppression_model->county_listings($year,$month);

		$this->load->view('county_listings',$data);
	}

	function site_listings($year=NULL,$month=NULL,$partner=NULL)
	{
		$data['facilities'] = $this->nonsuppression_model->facility_listing($year,$month);

		$this->load->view('site_listings',$data);
	}

	function regimen_listings($year=NULL,$month=NULL,$county=NULL)
	{
		$data['regimens'] = $this->nonsuppression_model->regimen_listing($year,$month,$county);

		$this->load->view('regimen_listings_view',$data);
	}

	function partner_listing($year=NULL,$month=NULL,$county=NULL)
	{
		$data['partners'] = $this->nonsuppression_model->partners($year,$month,$county);

    	$this->load->view('sup_partner_listing',$data);
	}
	
	function display_date()
	{
		echo "(".$this->session->userdata('filter_year')." ".$this->nonsuppression_model->resolve_month($this->session->userdata('filter_month')).")";
	}

	function display_range()
	{
		echo "(".($this->session->userdata('filter_year')-1)." - ".$this->session->userdata('filter_year').")";
	}
}
?>