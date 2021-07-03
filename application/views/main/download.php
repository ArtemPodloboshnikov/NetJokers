<?php 
	
	function createExcel($data, $title)
	{
		mb_internal_encoding("latin1");
		PHPExcel_Settings::setLocale('ru');
		$phpexcel = new PHPExcel();
		$phpexcel->setActiveSheetIndex(0); 

		PHPExcel_Settings::setLocale('ru');
		$page = $phpexcel->getActiveSheet();
		$page->setCellValue("A1", "Id");
		$page->setCellValue("B1", "Имя");
		$page->setCellValue("C1", "Действие");
		$page->setCellValue("D1", "Дата");
		for ($i = 0; $i < count($data); $i++) {
			$page->setCellValue("A".($i + 2), $data[$i]['history_id']);
			$page->setCellValue("B".($i + 2), $data[$i]['user_name']);
			$page->setCellValue("C".($i + 2), $data[$i]['action']);
			$page->setCellValue("D".($i + 2), $data[$i]['date']);
			//debug("A".($i + 2).": ".$data[$i]['user_name']);

		}

		$page->setTitle($title); // Заголовок делаем "Example"
		 /* Начинаем готовиться к записи информации в xlsx-файл */
		$date = getdate();

		 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
		 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
		 header ( "Cache-Control: no-cache, must-revalidate" );
		 header ( "Pragma: no-cache" );
		 header ( "Content-type: application/vnd.ms-excel" );
		 header ( "Content-Disposition: attachment; filename=".$title.".xls" );

		$objWriter = new PHPExcel_Writer_Excel2007($phpexcel);
		$objWriter->save('php://output');
		exit;
	}

	switch ($_POST['action'])
	{
		case "history":
		{
			// debug($_POST['action']);
			createExcel($_SESSION['data'], "History");
			unset($_SESSION['data']);
			//header("Location: ".$_SESSION['constants']['CURRENT_DOMEN']."admin");
			break;
		}
	}

?>