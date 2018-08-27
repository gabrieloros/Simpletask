<?php

class ExportXLS extends Render {
	
	function __construct() {
	
	}
	
	public function export($header1, $header2, $list){
		
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
									 ->setTitle("Reclamos " . date("d-m-Y"))
									 ->setSubject("Reclamos " . date("d-m-Y"))
									 ->setDescription("Reclamos " . date("d-m-Y"))
									 ->setKeywords("reclamos cau")
									 ->setCategory("Reclamos");
		
		//Header 1
		$row = 3;
		foreach ($header1 as $key => $header1element){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, $row, $header1element);
		}
		
		//Header 2
		$row = 4;
		foreach ($header2 as $key => $header2element){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, $row, $header2element);
		}
		
		//List data
		$row = 5;
		$referenceDate = null;
		$changeDayRows = array();
		
			foreach ($list as $key => $listElement){
			
			$entryDate = $listElement->getEntryDate();
			$closeDate = $listElement->getClosedDate();
			
			$date = is_object($entryDate)?$entryDate->format('d/m/Y'):'';
			$closeDate = is_object($closeDate)?$closeDate->format('d/m/Y'):'';
			
			//Fecha de envio
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $date);
			
			//Codigo
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $listElement->getCode());
			
			//Fecha de pedido
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $date);
			
			//Fecha de cierre
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $closeDate);
						
			//Barrio
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $listElement->getNeighborhood());
			
			//Direccion del Reclamo
			if(method_exists($listElement, 'getClaimAddress')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $listElement->getClaimAddress());
			}
			else{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, "IDEM");
			}
			
			//Nombre del solicitante
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $listElement->getRequesterName());
			
			//Dirección del solicitante
			if(method_exists($listElement, 'getRequesterAddress')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $listElement->getRequesterAddress());	
			}
			else{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "IDEM");
			}
			
			//Telefono del solicitante
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $listElement->getRequesterPhone());
			
			//Datos propios de alumbrado público
			if(method_exists($listElement, 'getPiquete')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $listElement->getPiquete());
			}
			if(method_exists($listElement, 'getFusible')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $listElement->getFusible());
			}
			if(method_exists($listElement, 'getLamp_125')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $listElement->getLamp_125());
			}
			if(method_exists($listElement, 'getLamp_150')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $listElement->getLamp_150());
			}
			if(method_exists($listElement, 'getLamp_250')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $listElement->getLamp_250());
			}
			if(method_exists($listElement, 'getLamp_400')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $listElement->getLamp_400());
			}
			if(method_exists($listElement, 'getExt_125')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $listElement->getExt_125());
			}
			if(method_exists($listElement, 'getExt_150')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $listElement->getExt_150());
			}
			if(method_exists($listElement, 'getExt_250')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $listElement->getExt_250());
			}
			if(method_exists($listElement, 'getExt_400')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, $listElement->getExt_400());
			}
			if(method_exists($listElement, 'getInt_125')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $listElement->getInt_125());
			}
			if(method_exists($listElement, 'getInt_150')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $listElement->getInt_150());
			}
			if(method_exists($listElement, 'getInt_250')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $row, $listElement->getInt_250());
			}
			if(method_exists($listElement, 'getInt_400')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, $row, $listElement->getInt_400());
			}
			if(method_exists($listElement, 'getMorceto')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $row, $listElement->getMorceto());
			}
			if(method_exists($listElement, 'getEspejo')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $row, $listElement->getEspejo());
			}
			if(method_exists($listElement, 'getColumna')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $row, $listElement->getColumna());
			}
			if(method_exists($listElement, 'getAtrio')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26, $row, $listElement->getAtrio());
			}
			if(method_exists($listElement, 'getNeutro')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27, $row, $listElement->getNeutro());
			}
			if(method_exists($listElement, 'getCable')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28, $row, $listElement->getCable());
			}
			if(method_exists($listElement, 'getTulipa')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29, $row, $listElement->getTulipa());
			}
			if(method_exists($listElement, 'getPortalampara')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30, $row, $listElement->getPortalampara());
			}
			if(method_exists($listElement, 'getCanasto')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31, $row, $listElement->getCanasto());
			}
			$detail = '';
			if(method_exists($listElement, 'getLights')){
				if($listElement->getLights() != '' || $listElement->getLights() != NULL){
					$detail .= 'Luminarias: '.$listElement->getLights();
				}
			}
			if(method_exists($listElement, 'getDetail')){
				if($listElement->getDetail() != '' || $listElement->getDetail() != NULL){
					if($detail != '')
						$detail .= ' - ';
					$detail .= $listElement->getDetail();
				}
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32, $row, $detail);
			if(method_exists($listElement, 'getLatitude')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(33, $row, $listElement->getLatitude());
			}
			if(method_exists($listElement, 'getLongitude')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(34, $row, $listElement->getLongitude());
			}
			if(method_exists($listElement, 'getDependencyName')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(35, $row, $listElement->getDependencyName());
			}
			
			//checking day change
			if($referenceDate != $listElement->getEntryDate()){
				$changeDayRows [] = $row;
			}
			$referenceDate = $listElement->getEntryDate();
			
			$row ++;
			
		}
				
		//Styles
		for($i = 0; $i <= count($header2)-1; $i++){
			
			$commonStyles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$commonStyles ['font'] = array('bold' => true);
			
			//header styles
			$this->applyCellStyle($objPHPExcel, $i, 3, $commonStyles);
			$this->applyCellStyle($objPHPExcel, $i, 4, $commonStyles);
			
			//Data styles
			for($j = 5; $j <= 4+count($list); $j++){
				
				$commonStyles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$commonStyles ['font'] = array('bold' => false);
				
				$this->applyCellStyle($objPHPExcel, $i, $j, $commonStyles);
				
			}
			
		}
		
		//Colouring rows according to day change
		$k = 0;		
		foreach ($changeDayRows as $rowChange){
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowChange.':J'.$rowChange)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($colorsList[$k]);
			
			if($k == count($colorsList)-1){
				$k = 0;
			}
			else{
				$k++;
			}
		}
		
		//Columns width
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(32)->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(33)->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(34)->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(35)->setAutoSize(true);
		
		//Merge headers
		$objPHPExcel->getActiveSheet()->mergeCells('L3:O3');
		$objPHPExcel->getActiveSheet()->mergeCells('P3:S3');
		$objPHPExcel->getActiveSheet()->mergeCells('T3:W3');
		
		// Rename worksheet
		$sheetTitle = "Reclamos " . date("d-m-Y");
		$objPHPExcel->getActiveSheet()->setTitle($sheetTitle);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reclamos_'.date("d-m-Y").'.xls"');
		header('Cache-Control: max-age=0');
		
		//Create XLS file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		return ob_get_clean();
		
	}
	
	private function applyCellStyle($objPHPExcel, $column, $row, $styles = array()){
		
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->applyFromArray($styles);
		
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->getFont()->setSize(8);
		
	}
	
}