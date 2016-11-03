<?php
if(!defined("BASEPATH")) exit("No direct script access allowed!");
	/**
	* 
	*/
	class MY_Controller extends MX_Controller
	{
		public $data = array();
		function __construct()
		{
			parent:: __construct();
			$this->initialize_filter();
			$this->data['part'] = FALSE;
			$this->data['labs'] = FALSE;
			$this->data['sit'] = FALSE;
			$this->data['county'] = FALSE;
			$this->data['contacts'] = FALSE;
		}

		public function load_libraries($arr){

			array_unshift($arr, "jquery","bootstrap");
					
			$libs['js_files']				=	array();		
			$libs['css_files']				=	array();			
			$libs['js_plugin_files']		=	array();
			$libs['css_plugin_files']		=	array();

			$asset_path		=	$this->config->item('asset_path');

			$css_path		=	$this->config->item('asset_path');
			$js_path		=	$this->config->item('js_path');
			$plugin_path	=	$this->config->item('plugin_path');

			$all_css		=	$this->config->item('css_files');
			$all_js			=	$this->config->item('js_files');
			$all_plugin_css	=	$this->config->item('plugin_css_files');
			$all_plugin_js	=	$this->config->item('plugin_js_files');
			//load css
			foreach ($arr as $css) {
				foreach($all_css as $all){
					if($css==$all['title']){
						$libs['css_files']			=	array_merge($libs['css_files'],array($all['file']));
					}
				}
			}
			//load js
			foreach ($arr as $js) {
				foreach($all_js as $all){
					if($js==$all['title']){
						$libs['js_files']			=	array_merge($libs['js_files'],array($all['file']));
					}
				}
			}
			//load plugin css
			foreach ($arr as $css) {
				foreach($all_plugin_css as $all){
					if($css==$all['title']){
						$libs['css_plugin_files']	=	array_merge($libs['css_plugin_files'],array($all['file']));
					}
				}
			}
			//load plugin js
			foreach ($arr as $js) {
				foreach($all_plugin_js as $all){
					if($js==$all['title']){
						$libs['js_plugin_files']	=	array_merge($libs['js_plugin_files'],array($all['file']));

					}
				}
			}	
			return 	$libs;
		}

		function initialize_filter()
		{
			if(!$this->session->userdata('filter_year'))
			{
				$filter_data = array(
								'county_filter' => null,
								'partner_filter' => null,
								'filter_year' => Date('Y'),
								'filter_month' => null
								);
				$this->session->set_userdata($filter_data);
			}
		}

		function set_filter_date($data=null)
		{
			$year = $data['year'];
			$month = $data['month'];
			
			if ($year) {
				$return = $this->session->set_userdata('filter_year', $year);
				$this->session->unset_userdata('filter_month');
			} else {
				if ($month=='all') {
					$this->session->unset_userdata('filter_month');
				}else {
					$this->session->set_userdata('filter_month', $month);
				}
			}
			$this->load->model('template/template_model');
			if(!$year)
				$year = $this->session->userdata('filter_year');
			if(!$month)
				$month = $this->session->userdata('filter_month');
			
			echo json_encode(array('year' => $year, 'prev_year' => $year-1, 'month' => $this->template_model->resolve_month($month) ));
		}

		function template($data)
		{
			$this -> load -> module('template');
			$this -> template ->load_template($data);
		}

		function filter_regions($data=NULL)
		{
			if (!$data) {//if $data is null
				
			} else {//if data is not null
				if ($data['county']==48||$data['county']=='NA') {
					$this->session->set_userdata('county_filter', null);
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('partner_filter', null);
					$this->session->unset_userdata('site_filter');
				}else{
					$this->session->set_userdata('county_filter', $data['county']);
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('partner_filter', null);
					$this->session->unset_userdata('site_filter');
				}
			}
			
			return TRUE;
		}
		function filter_partners($data=NULL)
		{
			if (!$data) {
				
			} else {
				if ($data['partner']=='NA') {
					$this->session->unset_userdata('partner_filter');
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('county_filter', null);
					$this->session->unset_userdata('site_filter');
				}else{
					$this->session->set_userdata('partner_filter', $data['partner']);
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('county_filter', null);
					$this->session->unset_userdata('site_filter');
				}
			}
			
			return TRUE;
		}

		function filter_site($data=null)
		{
			if (!$data) {
				
			} else {
				if ($data['site']=='NA') {
					$this->session->unset_userdata('site_filter');
					$this->session->set_userdata('partner_filter', null);
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('county_filter', null);
				}else{
					$this->session->set_userdata('site_filter', $data['site']);
					$this->session->set_userdata('partner_filter', null);
					$this->session->set_userdata('filter_month', null);
					$this->session->set_userdata('county_filter', null);
				}
			}
			
			return TRUE;
		}

		function display_time_period()
		{
			$display = array('year' => $this->session->userdata('filter_year'), 'month' => $this->session->userdata('filter_month') );

			echo json_encode($display);
		}

		
	}
?>