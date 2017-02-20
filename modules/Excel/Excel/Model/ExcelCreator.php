<?php

namespace Excel\Model;

class ExcelCreator extends \G2Design\G2App\Model {

	var $data = null, $excel, $filename = 'download.xlsx';

	public function __construct($data) {
		$this->data = $data;
//		$this->excel = new \PHPExcel();
		$this->excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$this->excel->setActiveSheetIndex(0);
		$this->set_data($data);
	}

	function set_data($data, $starting_row = 1, $starting_col = 1) {
		//Convert to matrix with headers in spererate row
		$headers = array_keys(current($data));
		$pdata = [$headers];

		foreach ($data as $row) {
			$pdata[] = array_values($row);
		}

		//Add to the matrix
		$sheet = $this->excel->setActiveSheetIndex(0);
		foreach ($pdata as $rindex => $row) {
			foreach ($row as $cindex => $col) {

				$sheet->setCellValueByColumnAndRow($cindex, $rindex + 1, $col, false);
			}
		}
	}

	function set_title($title) {
		$this->excel->getProperties()->setTitle($title);
		$this->excel->getActiveSheet()->setTitle($title);
	}

	function set_filename($filename) {
		$this->filename = $filename;
	}

	public function download() {
		
		foreach($this->excel->getActiveSheet()->getColumnDimensions() as $column) $column->setAutoSize (true);
		foreach (range(1, 50) as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimensionByColumn($columnID)
					->setAutoSize(true);
		}
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$this->filename.'"');
		header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$objWriter =  \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->excel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}

	function getNameFromNumber($num) {
		$numeric = ($num - 1) % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval(($num - 1) / 26);
		if ($num2 > 0) {
			return getNameFromNumber($num2) . $letter;
		} else {
			return $letter;
		}
	}

}
