<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends MY_Controller {

	
	public function index()
	{
		 if( $z <= 1) return true;

	    for( $elf = floor(sqrt($z)); $elf > 1; $elf--) { 
	        for( $rtk = ceil(log($z)/log($elf)); $rtk > 1; $rtk--) { 
	            if( pow($elf,$rtk) == $z) return true;
	            break;
	        }
	        
	    }
	    return false;
		
	}

}
?>