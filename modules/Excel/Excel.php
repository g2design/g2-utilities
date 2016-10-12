<?php
/**
 * 
 */
class Excel extends \G2Design\ClassStructs\Module {
	
	public function __construct() {
		//Add controller for downloads
		
	}
	
	public function init() {
		$this->addController('download', '\Excel\Controller\Download');
	}
	
	/**\
	 * Functions sets data for download and redirects to download this data
	 * 
	 */
	public static function download($data, $title = "", $filename = "") {
		$instance = G2Design\G2App::get_module_instance(__FILE__); /* @var $instance Excel */
		$instance->session()->set('Excel_Download', $data);
		$instance->session()->set('Excel_Title', $title);
		$instance->session()->set('Excel_Filename', $filename);
		header('Location: '.\G2Design\Utils\Functions::get_current_site_url().'excel/download');
		die();
	}

}