<?php

class TelepromStatsXLS extends Render {
	
	function __construct() {
	
	}
	
	public function export($header1, $list){
		
		/** Include PHPExcel */
		set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/../application/util/importer/PHPExcel/PHPExcel/');
		require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/util/importer/PHPExcel/PHPExcel.php';
		
		//Common Styles
		$commonStyles = array(
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
				'left' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				)
			),
		);
		
		//Colors list for row date change
		$colorsList = array('FFFFC000', 'FFFFFF00', 'FF92D050', 'FF00602B', 'FF00B0F0', 'FF0070C0');
				
		ob_start();
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("CVT")
									 ->setLastModifiedBy("CVT")
									 ->setTitle("Reclamos Teleprom " . date("d-m-Y"))
									 ->setSubject("Reclamos Teleprom " . date("d-m-Y"))
									 ->setDescription("Reclamos Teleprom " . date("d-m-Y"))
									 ->setKeywords("reclamos cau")
									 ->setCategory("Reclamos");
		
		//Header 1
		$row = 1;
		foreach ($header1 as $key => $header1element){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, $row, $header1element);
		}
		
		//List data
		$row = 2;
		$totalGlobal = 0;
		
		foreach ($list as $key => $listElement){
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $key);
			
			$total = 0;
			
			if(is_array($listElement) && count($listElement) > 0){
				
				foreach ($listElement as $causeKey => $count){
					
					if($causeKey != 'emptyCause'){
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $causeKey);
					}
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $count);
					
					$total += (int)$count;
					$totalGlobal += (int)$count;
					
					$row ++;
					
				}
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "TOTAL");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $total);
				
				$row ++;
				
			}
			
			$row ++;
			
		}
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "TOTAL GLOBAL");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $totalGlobal);
		
		//Styles
		for($i = 0; $i <= count($header1)-1; $i++){
			
			$commonStyles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$commonStyles ['font'] = array('bold' => true);
			
			//header styles
			$this->applyCellStyle($objPHPExcel, $i, 0, $commonStyles);
			$this->applyCellStyle($objPHPExcel, $i, 1, $commonStyles);
			$this->applyCellStyle($objPHPExcel, $i, 2, $commonStyles);
			
			//Data styles
			for($j = 2; $j <= ($row); $j++){
				
				$commonStyles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				
				if($i != 0){
					$commonStyles ['font'] = array('bold' => false);
				}
				
				$this->applyCellStyle($objPHPExcel, $i, $j, $commonStyles);
				
			}
			
		}
		
		//Columns width
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(26);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(16);
		
		// Rename worksheet
		$sheetTitle = "Reclamos Teleprom" . date("d-m-Y");
		$objPHPExcel->getActiveSheet()->setTitle($sheetTitle);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reclamos_Teleprom_'.date("d-m-Y").'.xls"');
		header('Cache-Control: max-age=0');
		
		//Create XLS file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		return ob_get_clean();
		
	}
	
	private function applyCellStyle($objPHPExcel, $column, $row, $styles = array()){
		
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->applyFromArray($styles);
		
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->getFont()->setName('Verdana');
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->getFont()->setSize(11);
		
	}
	
}