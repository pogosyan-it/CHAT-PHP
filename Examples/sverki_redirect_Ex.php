<?php
 session_start(); 
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['sverki_redirect'])){
     header("Location: \Menu.php");
     exit;                    }  

   if(!preg_match('[\d] ', $_POST['date_from']) or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \sverki_redirect.php");      
    exit;
  }
$date_from = $_POST['date_from'].' 00:00:00';
$date_by = $_POST['date_by'].' 23:59:59';
 # echo  $date_from, $date_by;

  if ($date_from > $date_by)
  {
  $_SESSION['Nocorrectdate'] = $date_by;  
        header("Location: \sverki_redirect.php");      
    exit;
  } 
  
$link = new mysqli(
         "10.10.1.2",  // Хост, к которому мы подключаемся 
            "root",      // Имя пользователя  
            "2me32jvppn",    // Используемый пароль 
            "gsotldb");     // База данных для запросов по умолчанию  
    $link->set_charset("cp1251");
          
 /** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
  
// Create new PHPExcel object
// Создаем объект класса PHPExcel
$xls = new PHPExcel();
// Устанавливаем индекс активного листа
$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();
  $sheet->getPageSetup()
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Подписываем лист
$sheet->setTitle('Сверки переадресация');
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:C1');
$date = date('Y-m-d_H-i');
$sheet->setCellValue('A1', 'Интервал с '.$date_from.' по '.$date_by);
$sheet->setCellValue('A2', '№ накладной');
$sheet->setCellValue('B2', 'Комментарий');


$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$sheet->getColumnDimension('A')->setWidth(12); 
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

#$sheet->getStyle('A2:C2')->getAlignment()->setWrapText(true);

$sheet->getStyle('A2:B2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:B2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:B2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


/*$sheet->getColumnDimension('A')->setWidth(13);  
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getStyle('A') ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  //Выравнивание по центру    */

$sheet->getStyle('A1:B1')->getFont()->setBold(true);
$sheet->getStyle('A2:B2')->getFont()->setBold(true);                  
$rowex=3;  
     $result = mysqli_query($link, "select d15_departures.WayBillNum as 'Накладная', GROUP_CONCAT(d20_extask.Comments order by d20_extask.ID ASC SEPARATOR ' ||  ') as 'Комментарий' from d20_extask
                                    left join d15_departures on d15_departures.ID = d20_extask.dXXID
                                    left join hbc_extaskstates on hbc_extaskstates.ID = d20_extask.stateKey
                                    where d15_departures.ID in (select d15_departures.ID
                                    from d15_departures
                                    left join d20_extask on d20_extask.dXXID = d15_departures.ID
                                    left join hbc_routes a on a.ID=d20_extask.RouteID
                                    left join hbc_routes b on b.ID=d15_departures.R_RouteID
                                    where d15_departures.ID in
                                    (select d15_departures.ID from d15_departures
                                    left join d20_extask on d20_extask.dXXID = d15_departures.ID
                                    where d20_extask.RouteID <> d15_departures.R_RouteID and d20_extask.stateKey in ('3','4','5','6','7') and d15_departures.SY_Void=0 and d15_departures.WayBillNum not in ('Снят!')
                                    and d15_departures.R_RouteID > '0')
                                    and a.Name <> b.Name and d20_extask.ExTimeStamp > '$date_from' and d20_extask.ExTimeStamp < '$date_by' 
                                    and d15_departures.FromDivID not in ('1')) and d20_extask.Comments is not NULL and d20_extask.Comments not in ('
                                    ',' ','')  
                                    group by d15_departures.ID order by d20_extask.ExTimeStamp"); 
     while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {     
                       $str=$row[1];                   
                       $str=iconv("cp1251", "utf-8", $str); 
                    #  $row[1]=iconv("cp1251", "utf-8", $row[1]);  
                      # $num=mb_strlen($row[1]);
                   if (mb_strlen($str)>10)  {  
                                                      $sheet->setCellValueByColumnAndRow(0, $rowex, $row[0]);
                                                      $sheet->setCellValueByColumnAndRow(1, $rowex, $str);                                                      
                                                 }
                       else {$rowex=$rowex-1;}                    
               $rowex++;                     
                  }              

    
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename= $date.xlsx");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
$objWriter->save('php://output');
exit;    
  