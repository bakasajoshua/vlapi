<?php
	ob_start();
	$this->load->view('header_view');
	
	if ($labs) {
		$this->load->view('utils/date_filter_view');
	}else if ($part) {
		$this->load->view('utils/partner_filter_view');
	}else if ($sit) {
		$this->load->view('utils/site_filter_view');
	}else if ($county) {
		$this->load->view('utils/date_filter_view');
	}else if ($contacts) {

	}else {
		$this->load->view('utils/filter_view');
	}
	
	$this->load->view($content_view);
	$this->load->view('footer_view');
?>