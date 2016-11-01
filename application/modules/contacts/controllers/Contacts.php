<?php
defined('BASEPATH') or exit('No direct script access allowed!');
require_once('phpmailer/class.phpmailer.php');
define('GUSER', 'ampathlabmail@gmail.com'); // Gmail username
define('GPWD', 's1mplepl@n'); // Gmail password
/**
* 
*/
class Contacts extends MY_Controller
{
	public $data = array();
	
	
	function __construct()
	{
		parent::__construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','custom')));
		$this->data['contacts'] = TRUE;
		// $this->load->library('phpmailer/class.phpmailer');
	}

	function index()
	{
		$this->data['content_view'] = 'contacts/contacts_view';
		// echo "<pre>";print_r($this->data);die();
		$this -> template($this->data);
	}

	function submit()
	{
		$data = array();
		$name = $this->input->post('cname');
		$email = $this->input->post('cemail');
		$subject = $this->input->post('csubject');
		$message = $this->input->post('cmessage')."\n\nFind me at ".$this->input->post('cphone');

		$responce = $this->smtpmailer($email, $name, $subject, $message);
		if ($responce) {
			$sent = 1;
		} else {
			$sent = 0;
		}
		
		echo $sent;
	}

	function smtpmailer($from, $from_name, $subject, $body) { 
		global $error;
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; 
		$mail->Username = GUSER;  
		$mail->Password = GPWD;           
		$mail->SetFrom($from, $from_name);
		$mail->Subject = 'VL DASHBOARD: '.$subject;
		$mail->Body = $body;
		$mail->AddAddress('jbatuka@usaid.gov');
		$mail->AddAddress('jhungu@clintonhealthaccess.org');
		$mail->AddAddress('jlusike@clintonhealthaccess.org');
		$mail->AddAddress('tngugi@clintonhealthaccess.org');
		$mail->AddAddress('baksajoshua09@gmail.com');
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			$error = 'Message sent!';
			return true;
		}
	}

	function validate_email($email=null)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		  echo 1;
		} else {
		  echo 0;
		}
	}
}
?>