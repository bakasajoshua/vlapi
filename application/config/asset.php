<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sekati CodeIgniter Asset Helper
 *
 * @package		Assets
 * @author		Omondi Kevin && Joshua Bakasa 
 * @copyright	Copyright (c) 2013, Sekati LLC.
 * @license		http://www.opensource.org/licenses/mit-license.php
 * @link		http://sekati.com
 * @version		v1.2.7
 * @filesource
 *
 * @usage 		$autoload['config'] = array('asset');
 * 				$autoload['helper'] = array('asset');
 * @example		<img src="<?=asset_url();?>imgs/photo.jpg" />
 * @example		<?=img('photo.jpg')?>
 *
 * @install		Copy config/asset.php to your CI application/config directory
 *				& helpers/asset_helper.php to your application/helpers/ directory.
 * 				Then add both files as autoloads in application/autoload.php:
 *
 *				$autoload['config'] = array('asset');
 * 				$autoload['helper'] = array('asset');
 *
 *				Autoload CodeIgniter's url_helper in `application/config/autoload.php`:
 *				$autoload['helper'] = array('url');
 *
 * @notes		Organized assets in the top level of your CodeIgniter 2.x app:
 *					- assets/
 *						-- css/
 *						-- download/
 *						-- img/
 *						-- js/
 *						-- less/
 *						-- swf/
 *						-- upload/
 *						-- xml/
 *					- application/
 * 						-- config/asset.php
 * 						-- helpers/asset_helper.php
 */

/*
|--------------------------------------------------------------------------
| Custom Asset Paths for asset_helper.php
|--------------------------------------------------------------------------
|
| URL Paths to static assets library
|
*/

$config['asset_path'] 		= 	'assets/';
$config['css_path'] 		= 	'assets/css/';
$config['download_path'] 	= 	'assets/download/';
$config['less_path'] 		= 	'assets/less/';
$config['js_path'] 			= 	'assets/js/';
$config['img_path'] 		= 	'img/';
$config['swf_path'] 		= 	'assets/swf/';
$config['upload_path'] 		= 	'assets/upload/';
$config['xml_path'] 		= 	'assets/xml/';
$config['plugin_path']		=	'assets/plugins/';
$config['files_path']		=	'assets/files/';

$config['css_files']		=	array(
									array('title' => 'styles'	,	'file'	=>	'styles.css'),
									array('title' => 'custom'	,	'file'	=>	'custom.css')
								);
$config['js_files']			=	array(
									
								);
$config['plugin_js_files']	=	array(
									array('title'=> 'jquery',		'file'	=>	'jquery/jquery-2.2.3.min.js'),
									array('title'=> 'bootstrap'	,	'file'	=>	'bootstrap/js/bootstrap.min.js'),
									array('title'=> 'material',		'file'	=>	'bootstrap/js/material.min.js'),
									array('title'=> 'ripples',		'file'	=>	'bootstrap/js/ripples.min.js'),
									array('title'=> 'highstock',	'file'	=>	'highstock/js/highstock.js'),
									array('title'=> 'highmaps',		'file'	=>	'highmaps/js/modules/map.js'),
									array('title'=> 'highmaps',		'file'	=>	'highmaps/js/modules/mapdata/countries/ke/ke-all.js'),
									array('title' => 'Kenya', 		'file' => 'highmaps/kenya.js'
										),
									array('title'=> 'tablecloth',		'file'	=>	'tablecloth/js/jquery.metadata.js'),
									array('title'=> 'tablecloth',		'file'	=>	'tablecloth/js/jquery.tablesorter.min.js'),
									array('title'=> 'tablecloth',		'file'	=>	'tablecloth/js/jquery.tablecloth.js'),
									array('title'=> 'select2',			'file'	=>	'select2/js/select2.min.js')
								);	
$config['plugin_css_files']	=	array(
									array('title'=> 'bootstrap'	,	'file'	=>	'bootstrap/css/bootstrap.min.css'),
									array('title'=> 'material'	,	'file'	=>	'bootstrap/css/bootstrap-material-design.min.css'),
									array('title'=> 'ripples',		'file'	=>	'bootstrap/css/ripples.min.css'),
									array('title'=> 'bootstrap',	'file'	=>	'bootstrap/css/bootstrap-theme.min.css'),
									array('title'=> 'bootstrap',	'file'	=>	'bootstrap/css/bootstrap-responsive.css'),
									array('title'=> 'tablecloth',	'file'	=>	'tablecloth/css/tablecloth.css'),
									array('title'=> 'tablecloth',	'file'	=>	'tablecloth/css/prettify.css'),
									array('title'=> 'select2',		'file'	=>	'select2/css/select2.min.css')
								);
$config['plugin_php_files']	=	array(
									// array('title'	=> 	'phpexcel'		,			'file'	=>	'PHPExcel/PHPExcel.php'),
								);
/* End of file asset.php */
