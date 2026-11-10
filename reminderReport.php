<?php
	require('../media/PHPExcel.php');
	require_once ("notif-oop.php");
	$keyword = $_GET['keyword'];
	$endDate = date('Y/m/d', strtotime($_GET['enddate']));
	$startDate = date('Y/m/d', strtotime($_GET['startdate']));
	session_start();
	$userid= $_SESSION["truserid"];
	if (array_key_exists("username", $_SESSION))
	{
		$username = $_SESSION['username'];
	}
	$dateToday = date("M. d, Y");
	$dateCtrl = date("Y-m");
	//create new phpexcel page
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Lucida Fax');
	//set font
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	
	$objSheet = $objPHPExcel->getActiveSheet();
	$title = "Alert Notification System"; //set title cont.
	$objSheet->setTitle($title); //set title cont.
	
	//BORDERS STYLE
	//set all borders corner to thin 
	$styleArray = array(
	  'borders' => array(
		'allborders' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	  ),
	  'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'FFFFF'),
		)
	); 

	//WORD WRAP
	$objPHPExcel->getActiveSheet()->getStyle('A1:Z999')
    ->getAlignment()->setWrapText(true);
	
	//SET WIDTH
	$objSheet->getColumnDimension('A')->setWidth(30);
	$objSheet->getColumnDimension('B')->setWidth(30);
	$objSheet->getColumnDimension('C')->setWidth(30);
	$objSheet->getColumnDimension('D')->setWidth(15);
	$objSheet->getColumnDimension('E')->setWidth(15);
	$objSheet->getColumnDimension('F')->setWidth(15);
	$objSheet->getColumnDimension('G')->setWidth(12);
	$objSheet->getColumnDimension('H')->setWidth(30);
	//set style		
	$objSheet->getStyle('A1')->applyFromArray($styleArray);
	$objSheet->getStyle('B1')->applyFromArray($styleArray);
	$objSheet->getStyle('C1')->applyFromArray($styleArray);
	$objSheet->getStyle('D1')->applyFromArray($styleArray);
	$objSheet->getStyle('E1')->applyFromArray($styleArray);
	$objSheet->getStyle('F1')->applyFromArray($styleArray);
	$objSheet->getStyle('G1')->applyFromArray($styleArray);
	$objSheet->getStyle('H1')->applyFromArray($styleArray);
		
	$objSheet->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A1:H1')->getFont()->setBold(true)->setSize(10);
	//format 2
	$objSheet->getCell('A1')->setValue('Task Subject'); 
	$objSheet->getCell('B1')->setValue('Details'); 
	$objSheet->getCell('C1')->setValue('Recipient'); 
	$objSheet->getCell('D1')->setValue("Start Date"); 
	$objSheet->getCell('E1')->setValue('End Date'); 
	$objSheet->getCell('F1')->setValue('Date Created'); 
	$objSheet->getCell('G1')->setValue('Confirmation'); 
	$objSheet->getCell('H1')->setValue('Status');
	
	$colno = 2;
	$result = ALERT::getInstance()->generateReportByDate($keyword,$startDate,$endDate,$userid);
	while($row = mysqli_fetch_array($result)) {
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('A'.$colno, $row['alertsubj'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('B'.$colno, $row['details'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('C'.$colno, $row['recipient'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('D'.$colno, $row['startdate'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('E'.$colno, $row['enddate'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('F'.$colno, $row['datecreated'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('G'.$colno, $row['dateconfirm'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()
		->setCellValueExplicit('H'.$colno, $row['status'],PHPExcel_Cell_DataType::TYPE_STRING);
		$colno++;
		$objSheet->getStyle('A2:H'.($colno-1))->applyFromArray($styleArray);
	}
	
	unset($styleArray);
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename=AlertReport.xlsx');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
?>