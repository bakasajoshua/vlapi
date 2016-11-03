<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	function __construct()
	{
		parent:: __construct();
	}
	function resolve_month($month)
	{
		switch ($month) {
			case 1:
				$value = 'Jan';
				break;
			case 2:
				$value = 'Feb';
				break;
			case 3:
				$value = 'Mar';
				break;
			case 4:
				$value = 'Apr';
				break;
			case 5:
				$value = 'May';
				break;
			case 6:
				$value = 'Jun';
				break;
			case 7:
				$value = 'Jul';
				break;
			case 8:
				$value = 'Aug';
				break;
			case 9:
				$value = 'Sep';
				break;
			case 10:
				$value = 'Oct';
				break;
			case 11:
				$value = 'Nov';
				break;
			case 12:
				$value = 'Dec';
				break;
			default:
				$value = NULL;
				break;
		}

		return $value;

	}

	function req($url)
	{
		$this->load->library('requests/library/requests');
		$this->requests->register_autoloader();
		$headers = array('X-Auth-Token' => 'jhWXc65gZUI=yG5ndWkpAGNsaW50b85oZWFsdGhhY2Nlc3Mub3Jn');
		$request = $this->requests->get($url, $headers);

		return json_decode($request->body);
	}
}
?>