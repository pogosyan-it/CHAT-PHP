<?php

 session_start();
 if(!isset($_SESSION['loginIAO'])){
     header("Location: VhodIAO.php");
     exit;
 } 
$Login = $_SESSION['loginIAO'];
   if(!preg_match('[\d] ', $_POST['date_from']) or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \Dost.php");      
    exit;
  }
$date_from = $_POST['date_from'].' 00:00:00';
$date_by = $_POST['date_by'].' 23:59:59';
 # echo  $date_from, $date_by;

  if ($date_from > $date_by)
  {
  $_SESSION['Nocorrectdate'] = $date_by;  
        header("Location: \Dost.php");      
    exit;
  } 
  $city=$_POST['city'];
  $type=$_POST['parcell'];
  if ($city=='MOW')
  {
  $_SESSION['gorod'] = $city;  
        header("Location: \Dost.php");      
    exit;
   }
   
     if ($type=='Zakazy')
  {
  $_SESSION['tip'] = $type;  
        header("Location: \Dost.php");      
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

// Подписываем лист
$sheet->setTitle('fuck');
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
#$sheet->mergeCells('A1:C1');
#$date = date('d-m-Y H:i');
$sheet->setCellValue('A1','Населенный пункт отправки');
$sheet->setCellValue('B1','Маршрут');
$sheet->setCellValue('C1','Номер накладной');
$sheet->setCellValue('D1','Населенны пункт доставки');
$sheet->setCellValue('E1','Адрес Доставки');
$sheet->setCellValue('F1','Дата доставки');
$sheet->setCellValue('G1','Дата получения груза у перевозчика');
$sheet->setCellValue('H1','Дата сканирования');



$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);  
$sheet->getColumnDimension('H')->setAutoSize(true); 
 
 
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);

$sheet->getStyle('A1:H1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:H1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:H1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('H1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$sheet->getStyle('A1:H1')->getFont()->setBold(true);                    
$row1=2;  

      $result = mysql_query("SELECT b.Name as city_from, hbc_routes.Name as route,
                             d15_departures.WayBillNum as WaybillNum, hbc_cities.Name as city_to,
                             d15_departures.R_Addr as address,
                             d20_extask.ExTimeStamp as deliver_date,
                             d50_vo.lCargoReceived as Carrier_date, d56vo2departure.SY_LastEdit as scan_date
                             FROM d20_extask 
                             left join d15_departures on d20_extask.dXXID=d15_departures.ID 
                             left join d21_extasklist on d20_extask.d21ID=d21_extasklist.ID
                             left join hbc_routes on hbc_routes.ID=d15_departures.R_RouteID
                             left join hbc_cities on hbc_cities.ID=d15_departures.R_CityID
                             left join hbc_divisions on hbc_divisions.ID=d15_departures.FromDivID
                             left join hbc_cities b on b.ID=hbc_divisions.CityID

                             left join d56vo2departure on d15_departures.ID=d56vo2departure.d15ID
                             left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                             left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                             left join d50_vo on d30_manifests.d50ID=d50_vo.ID

                             where d15_departures.ToDivID='1' and d20_extask.stateKey='7' and hbc_routes.Name is not NULL 
                             and d20_extask.typeKey='4' and d15_departures.SY_Void=0  and hbc_routes.Name like 'MO%' 
                             and d20_extask.ExTimeStamp between '$date_from' and  '$date_by';");  
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
       
         $city_from=$row['city_from'];
         $route=$row['route'];
         $WaybillNum=$row['WaybillNum'];
         $city_to=$row['city_to'];
         $address=$row['address'];
         $deliver_date=$row['deliver_date'];
         $Carrier_date=$row['Carrier_date'];
         $scan_date=$row['scan_date'];
         
         $city_from=iconv("cp1251", "utf-8", $city_from); 
         $city_to=iconv("cp1251", "utf-8", $city_to); 
         $address=iconv("cp1251", "utf-8", $address);
         #$deliver_date=iconv("cp1251", "utf-8", $deliver_date); 
         #$Carrier_date=iconv("cp1251", "utf-8", $Carrier_date); 
         #$scan_date=iconv("cp1251", "utf-8", $scan_date); 
         #$route=iconv("cp1251", "utf-8", $route);
         $WaybillNum=iconv("cp1251", "utf-8", $WaybillNum);
                                       
    $sheet->setCellValueByColumnAndRow(0, $row1, $city_from);
    $sheet->setCellValueByColumnAndRow(1, $row1, $route);
    $sheet->setCellValueByColumnAndRow(2, $row1, $WaybillNum);  
    $sheet->setCellValueByColumnAndRow(3, $row1, $city_to);
    $sheet->setCellValueByColumnAndRow(4, $row1, $address);
    $sheet->setCellValueByColumnAndRow(5, $row1, $deliver_date);
    $sheet->setCellValueByColumnAndRow(6, $row1, $Carrier_date);                                      
    $sheet->setCellValueByColumnAndRow(7, $row1, $scan_date);
                                       
                               $row1++;         
                                                           }                  
   
 /*  for ($i = 2; $i < $row1; $i++)     {

$sheet->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);    
$sheet->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('H'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('H'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('H'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('H'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                                                                    }       */
    
  
     
// Выводим HTTP-заголовки
 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=$date_from.xls" );

// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 $objWriter->save('php://output'); 

// Echo memory usage        
  