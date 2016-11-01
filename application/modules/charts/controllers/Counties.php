<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Counties extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('counties_model');
	}

	function counties_tests($year = NULL, $month = NULL)
	{
		$data = $this->counties_model->country_tests($year, $month);

		echo json_encode($data);
	}

	function counties_suppressed($year = NULL, $month = NULL)
	{
		$data = $this->counties_model->country_suppression($year, $month);

		echo json_encode($data);
	}

	function counties_non_suppressed($year = NULL, $month = NULL)
	{
		$data = $this->counties_model->country_non_suppression($year, $month);

		echo json_encode($data);
	}

	function counties_rejects($year = NULL, $month = NULL)
	{
		$data = $this->counties_model->country_rejects($year, $month);

		echo json_encode($data);
	}

	function counties_pregnant($year = NULL, $month = NULL)
	{
		$data = $this->counties_model->country_pregnant($year, $month);

		echo json_encode($data);
	}

	function counties_lactating($year = NULL, $month = NULL)
	{
		$data = $this->counties_model->country_lactating($year, $month);

		echo json_encode($data);
	}

	function county_summary($county = NULL, $year = NULL, $month = NULL)
	{
		$data = $this->counties_model->county_summary($county, $year, $month);
		$this->load->library('table');
		$this->table->set_heading('Field', 'Value');
		$template = array(
	        'table_open'            => '<table  class="table table-bordered table-hover">',

	        'thead_open'            => '<thead>',
	        'thead_close'           => '</thead>',

	        'heading_row_start'     => '<tr>',
	        'heading_row_end'       => '</tr>',
	        'heading_cell_start'    => '<th>',
	        'heading_cell_end'      => '</th>',

	        'tbody_open'            => '<tbody>',
	        'tbody_close'           => '</tbody>',

	        'row_start'             => '<tr>',
	        'row_end'               => '</tr>',
	        'cell_start'            => '<td>',
	        'cell_end'              => '</td>',

	        'row_alt_start'         => '<tr>',
	        'row_alt_end'           => '</tr>',
	        'cell_alt_start'        => '<td>',
	        'cell_alt_end'          => '</td>',

	        'table_close'           => '</table>'
		);

	$this->table->set_template($template);
	echo $this->table->generate($data);
	}

	function county_details($county = NULL, $year = NULL, $month = NULL)
	{
		$data['outcomes'] = $this->counties_model->county_details($county, $year, $month);
		
		$this->load->view('county_details', $data);
	// 	$this->load->library('table');
	// 	$this->table->set_heading('Partner', 'Facility', 'Tests', 'Suppressed', 'Non Suppressed',
	// 	 'Rejected', 'Adults', 'Children');
	// 	$template = array(
	//         'table_open'            => '<table  id="example" cellspacing="1" cellpadding="3" class="table table-bordered table-hover" style="background:#CCC;">',

	//         'thead_open'            => '<thead>',
	//         'thead_close'           => '</thead>',

	//         'heading_row_start'     => '<tr>',
	//         'heading_row_end'       => '</tr>',
	//         'heading_cell_start'    => '<th>',
	//         'heading_cell_end'      => '</th>',

	//         'tbody_open'            => '<tbody>',
	//         'tbody_close'           => '</tbody>',

	//         'row_start'             => '<tr>',
	//         'row_end'               => '</tr>',
	//         'cell_start'            => '<td>',
	//         'cell_end'              => '</td>',

	//         'row_alt_start'         => '<tr>',
	//         'row_alt_end'           => '</tr>',
	//         'cell_alt_start'        => '<td>',
	//         'cell_alt_end'          => '</td>',

	//         'table_close'           => '</table>'
	// 	);

	// $this->table->set_template($template);
	// echo $this->table->generate($data);
	
	}


	
}
?>