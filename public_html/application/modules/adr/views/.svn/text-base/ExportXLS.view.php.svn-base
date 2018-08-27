<?php

class ExportXLS extends Render {

	function __construct() {

	}

	public function export($header1, $header2, $header3,$list, $summary){

		$rowHeight = 15;
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
		->setTitle("Actividad de usuario " . date("d-m-Y"))
		->setSubject("Actividad de usuario " . date("d-m-Y"))
		->setDescription("Actividad de usuario " . date("d-m-Y"))
		->setKeywords("actividad de usuario")
		->setCategory("Actividad de usuario");

		$row = 2;
		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $header3[0]);
		$row = 3;
		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $summary['initDate'].' - '.$summary['endDate'] );		
		
		$row = 5;
		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $header3[1].' '.$summary['user'] );
		
		$row = 7;
		$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
		
		 foreach ($header2 as $key => $header2element){
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, $row, $header2element);	
		 
		 }
		 $row = 8;
		 $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
		 		 
		 foreach ($summary['sumarybydate'] as $key => $value) {
		 	
		 	$date = date('d/m/Y', strtotime ($key));
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row,$date);
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value["countattended"]);
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $value["countunattended"]);
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $value["countpendingclaim"]);
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $value["countcancelclaim"]);
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $value["countclosedclaim"]);
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $value["countassigned"]);
		 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $value["hoursworked"]);
		 	
		 	$row++;	 			 			 	
		 	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
		 	
		 }

		 //Estableciendo totales
		 
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row,'TOTAL');
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $summary["totalAttended"]);
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $summary["totalUnnatended"]);
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $summary["totalPending"]);
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $summary["totalCancel"]);
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $summary["totalClosed"]);
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $summary["totalAssigned"]);
		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $summary["totalHoursWorked"]);
		 $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD4D4D4');
		 $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
	 	
		 $rowTotals = $row;			 			

		$row++;
		$row++;
		$rowMainHeader = $row;
		foreach ($header1 as $key => $header1element){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, $row, $header1element);
		}


		//List data
		$row ++;

		$mergeCell = false;
		$styles = array();
		$styles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		for($i = 0; $i <= count($list)-1; $i++){
			$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
				
			if($list[$i]["codeclaim"] == 'TRASLADO'){

				$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':U'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCDCDC');
				$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':U'.$row);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':U'.$row)->applyFromArray($styles);
				$mergeCell = true;
			}
				
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $list[$i]["codeclaim"]);
			if($mergeCell){

				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $list[$i]["timeIn"]);
				$mergeCell = false;
			}else{
				
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $list[$i]["entrydate"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $list[$i]["timeIn"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $list[$i]["timeOut"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $list[$i]["closedate"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $list[$i]["state"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $list[$i]["timeInZone"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $list[$i]["withoutfixingdetail"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $list[$i]["user"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $list[$i]["region"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $list[$i]["address"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $list[$i]["requestername"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $list[$i]["requesterphone"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $list[$i]["piquete"]);

				//Estableciendo materiales
				if(isset($list[$i]["materials"]) && count($list[$i]["materials"]) > 0){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, isset($list[$i]["materials"][0])?$list[$i]["materials"][0]:"");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, isset($list[$i]["materials"][1])?$list[$i]["materials"][1]:"");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, isset($list[$i]["materials"][2])?$list[$i]["materials"][2]:"");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, isset($list[$i]["materials"][3])?$list[$i]["materials"][3]:"");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, isset($list[$i]["materials"][4])?$list[$i]["materials"][4]:"");
						
					
				}else{
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, "");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, "");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, "");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, "");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $row, "");
						
					
				}
				
				//Estableciendo motivo de baja
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $row, $list[$i]["detail"]);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $row, $list[$i]["dependency"]);
				
			}			
			
			$row ++;
	
		}
//91E8FF
//FF00B0F0
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowMainHeader.':U'.$rowMainHeader)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF91E8FF');

		$commonStyles ['alignment'] = array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$commonStyles ['font'] = array('bold' => true);
		//Styles
		for($i = 0; $i <= count($header1)-1; $i++){

			//header styles
			$this->applyCellStyle($objPHPExcel, $i, $rowMainHeader, $commonStyles);

		}

		for($i = 0; $i <= count($header2)-1; $i++){
		
			$this->applyCellStyle($objPHPExcel, $i, 7, $commonStyles);
			$this->applyCellStyle($objPHPExcel, $i, $rowTotals, $commonStyles);
			}
		

			
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD4D4D4');
		$objPHPExcel->getActiveSheet()->getStyle('A5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD4D4D4');
		$objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD4D4D4');
		
			
		$this->applyCellStyle($objPHPExcel, 0, 2, $commonStyles);
		$this->applyCellStyle($objPHPExcel, 0, 5, $commonStyles);
			
		//Columns width
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(13)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(14)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(15)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(16)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(17)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(18)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(19)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(20)->setAutoSize(true);

		// Rename worksheet
		$sheetTitle = "Actividad usuario " . date("d-m-Y");
		$objPHPExcel->getActiveSheet()->setTitle($sheetTitle);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Actividad_usuario'.date("d-m-Y").'.xls"');
		header('Cache-Control: max-age=0');

		//Create XLS file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

		return ob_get_clean();

	}

	private function applyCellStyle($objPHPExcel, $column, $row, $styles = array()){

		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->applyFromArray($styles);

		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($column, $row)->getFont()->setSize(10);

	}

}