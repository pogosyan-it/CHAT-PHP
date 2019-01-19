<?php
 session_start();
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['LVR'])){
     header("Location: \Menu.php");
     exit;                    }  

   if(!preg_match('[\d] ', $_POST['date_from']) or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \LVR.php");      
    exit;
  }
$date_from = $_POST['date_from'].' 00:00:00';
$date_by = $_POST['date_by'].' 23:59:59';
 # echo  $date_from, $date_by;

  if ($date_from > $date_by)
  {
  $_SESSION['Nocorrectdate'] = $date_by;  
        header("Location: \LVR.php");      
    exit;
  } 

function connect()
{ // BEGIN function connect
	mysql_connect("10.10.1.2", "root", "2me32jvppn");
  mysql_set_charset("CP1251");
  mysql_select_db("gsotldb");
  mysql_query("SET NAMES 'CP1251'");
} // END function connect  
   
  connect();   
 
      
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
$sheet->setTitle('Лично в руки');
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:K1');
$date = date('Y-m-d_H:i');
$sheet->setCellValue('A1', 'Интервал с '.$date_from.' по '.$date_by);
$sheet->setCellValue('A2','№ Накладной');
$sheet->setCellValue('B2','№ Маршрута');
$sheet->setCellValue('C2','Город отправления');
$sheet->setCellValue('D2','Город доставки');
$sheet->setCellValue('E2','Вес Ф');
$sheet->setCellValue('F2','Мест');
$sheet->setCellValue('G2','Спец.Инструкции');
$sheet->setCellValue('H2','Курьер');
$sheet->setCellValue('I2','Время');
$sheet->setCellValue('J2','Ф.И.О.');
$sheet->setCellValue('K2','Комментарии');
$sheet->setCellValue('L2','Контактное лицо');
$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setWidth(6);
$sheet->getColumnDimension('F')->setWidth(5);
$sheet->getColumnDimension('G')->setAutoSize(true);  
$sheet->getColumnDimension('H')->setAutoSize(true); 
$sheet->getColumnDimension('I')->setWidth(17);
$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->getColumnDimension('K')->setAutoSize(true); 
$sheet->getColumnDimension('L')->setAutoSize(true);
    
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);

$sheet->getStyle('A2:L2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:L2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:L2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('K2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$sheet->getStyle('A1:L1')->getFont()->setBold(true);
$sheet->getStyle('A2:L2')->getFont()->setBold(true);                    
  $row1=3;  
    $lv='%лич%рук%';
    $lv=iconv("utf-8", "cp1251", $lv);
       $result = mysql_query("select WayBillNum, hbc_routes.Name as route, a.Name as SCity, b.Name as RCity, Sh_EWeight, Sh_Place,
                              Sh_Instructions, SName, ExTimeStamp, cpName, d20_extask.Comments, d15_departures.R_Contact
                              from d15_departures
                              left join hbc_cities a on a.ID=d15_departures.S_CityID
                              left join hbc_cities b on b.ID=d15_departures.R_CityID
                              left join hbc_routes on d15_departures.R_RouteID=hbc_routes.ID
                              left join d20_extask on d15_departures.ID=d20_extask.dXXID
                              left join d21_extasklist on d20_extask.d21ID=d21_extasklist.ID
                              left join hb_employee on hb_employee.ID=d21_extasklist.employeeID
                              where d20_extask.stateKey='7' and d15_departures.Sh_Instructions like '$lv'
                              and d20_extask.ExTimeStamp > '$date_from' and d20_extask.ExTimeStamp < '$date_by'"); 
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
       
         $WayBillNum=$row['WayBillNum'];
         $route=$row['route'];
         $SCity=$row['SCity'];
         $RCity=$row['RCity'];
         $Sh_EWeight=$row['Sh_EWeight'];
         $Sh_Place=$row['Sh_Place'];
         $Sh_Instructions=$row['Sh_Instructions'];
         $SName=$row['SName'];
         $ExTimeStamp=$row['ExTimeStamp'];
         $cpName=$row['cpName'];
         $Comments=$row['Comments'];
         $R_Contact=$row['R_Contact'];
              
         $SCity=iconv("cp1251", "utf-8", $SCity); 
         $RCity=iconv("cp1251", "utf-8", $RCity); 
         $Sh_Instructions=iconv("cp1251", "utf-8", $Sh_Instructions); 
         $SName=iconv("cp1251", "utf-8", $SName); 
         $cpName=iconv("cp1251", "utf-8", $cpName); 
         $Comments=iconv("cp1251", "utf-8", $Comments); 
         $R_Contact=iconv("cp1251", "utf-8", $R_Contact);
                                           
    $sheet->setCellValueByColumnAndRow(0, $row1, $WayBillNum);
    $sheet->setCellValueByColumnAndRow(1, $row1, $route);
    $sheet->setCellValueByColumnAndRow(2, $row1, $SCity);  
    $sheet->setCellValueByColumnAndRow(3, $row1, $RCity);
    $sheet->setCellValueByColumnAndRow(4, $row1, $Sh_EWeight);
    $sheet->setCellValueByColumnAndRow(5, $row1, $Sh_Place); 
    $sheet->setCellValueByColumnAndRow(6, $row1, $Sh_Instructions);                                      
    $sheet->setCellValueByColumnAndRow(7, $row1, $SName);
    $sheet->setCellValueByColumnAndRow(8, $row1, $ExTimeStamp);                                      
    $sheet->setCellValueByColumnAndRow(9, $row1, $cpName);
    $sheet->setCellValueByColumnAndRow(10, $row1, $Comments);
    $sheet->setCellValueByColumnAndRow(11, $row1, $R_Contact);

                                       
                               $row1++;         
                                                           }                  
   
  /* for ($i = 2; $i < $row1; $i++)     {
$sheet->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                                                                    }                   */
    
  
     
// Выводим HTTP-заголовки
 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=$date.xls" );

// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 $objWriter->save('php://output'); 

// Echo memory usage        
  