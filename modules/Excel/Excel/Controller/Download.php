<?php

namespace Excel\Controller;

class Download extends \G2Design\G2App\Controller {
	
	function getIndex() {
		//Check if session var isset
		$data = $this->session()->get('Excel_Download');
		$model = new \Excel\Model\ExcelCreator($data);
		$model->set_title($this->session()->get('Excel_Title'));
		$model->set_filename($this->session()->get('Excel_Filename'));
		$model->download();
	}
	
	function getTest(){
		$data = [
			['New Headers' => 'data', 'Header 2' => 'data'],
			['New Header' => 'data', 'Header 2' => 'data'],
			['New Header' => 'data', 'Header 2' => 'data'],
		];
		
		\Excel::download($data,'Test Data', 'testfilename.xlsx');
	}
	
	
}