<?php

class ExportXLS extends Render {
	
	function __construct() {
	
	}
	
	public function export($headerTitle,$headerReportofDate,$headerDate,$headerCounts,$headerTable,$list){
		
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
		

									
		//headerTitle
		$row= 2;
		foreach($headerTitle as $key => $headerTitleElement){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key,$row,$headerTitleElement);
		}

								
		//headerReportofDate
		$row= 4;
		foreach($headerReportofDate as $key => $headerReportofDateElement){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key,$row,$headerReportofDateElement);
		}

								
		//headerReportofDate
		$row= 5;
		foreach($headerDate as $key => $headerDateElement){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key,$row,$headerDateElement);
		}

		//headerCounts
		$row= 7;
		foreach($headerCounts as $key => $headerCountsElement){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key,$row,$headerCountsElement);
		}

		//Header 2
		$row = 9;
		foreach ($headerTable as $key => $headerTable){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, $row, $headerTable);
		}
		
		//List data
		$row = 10;
		$referenceDate = null;
		$changeDayRows = array();
		
			foreach ($list as $key => $listElement){
			
			$entryDate = $listElement->getEntryDate();
			$closeDate = $listElement->getClosedDate();
			
			$date = is_object($entryDate)?$entryDate->format('d/m/Y'):'';
			$closeDate = is_object($closeDate)?$closeDate->format('d/m/Y'):'';

			//Codigo
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $listElement->getCode());
			
			//Fecha de pedido
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $date);
			
			//Fecha de cierre
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $closeDate);

			//Estado
			if(method_exists($listElement, 'getStateName')){
				if($listElement->getStateName() == 'closed'){
					$state = 'Cerrado';
				}
				if($listElement->getStateName() == 'pending'){
					$state = 'Pendiente';
				}
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $state);
			}
			//Solicitante
			if(method_exists($listElement, 'getRequesterName')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $listElement->getRequesterName());
			}
			//Telefono del solicitante
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $listElement->getRequesterPhone());
			
			//Barrio
			//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $listElement->getNeighborhood());
			
			//Direccion del Reclamo
			if(method_exists($listElement, 'getClaimAddress')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $listElement->getClaimAddress());
			}
			else{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, "IDEM");
			}
			//ingreso
			if(method_exists($listElement, 'getInputTypeName')){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $listElement->getInputTypeName());
			}
			//origende ingreso
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $listElement->getOriginName());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $listElement->getUserName());

			
			if(method_exists($listElement, 'getMat_1')){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $listElement->getMat_1());
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $listElement->getMat_2());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $listElement->getMat_3());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $listElement->getMat_4());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $listElement->getMat_5());
			
			//Dirección del solicitante
			// if(method_exists($listElement, 'getRequesterAddress')){
			// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $listElement->getRequesterAddress());	
			// }
			// else{
			// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "IDEM");
			// }
			
			
			
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
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $detail);
		
		
			
			//checking day change
			if($referenceDate != $listElement->getEntryDate()){
				$changeDayRows [] = $row;
			}
			$referenceDate = $listElement->getEntryDate();
			
			$row ++;
			
		}
				
		//Styles
		// for($i = 0; $i <= count($header2)-1; $i++){
			
		// 	$commonStyles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// 	$commonStyles ['font'] = array('bold' => true);
			
		// 	//header styles
		// 	$this->applyCellStyle($objPHPExcel, $i, 3, $commonStyles);
		// 	$this->applyCellStyle($objPHPExcel, $i, 4, $commonStyles);
			
		// 	//Data styles
		// 	for($j = 5; $j <= 4+count($list); $j++){
				
		// 		$commonStyles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// 		$commonStyles ['font'] = array('bold' => false);
				
		// 		$this->applyCellStyle($objPHPExcel, $i, $j, $commonStyles);
				
		// 	}
			
		// }
		
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