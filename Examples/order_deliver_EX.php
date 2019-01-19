<?php
 session_start();
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['order_deliver'])){
     header("Location: Menu.php");
     exit;                    }  
   if(!preg_match('[\d] ', $_POST['date_from']) or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \order_deliver.php");      
    exit;
  }
  $date_from= new DateTime($_POST['date_from']);
    $date_by = new DateTime($_POST['date_by']);
    $interval = $date_by->diff($date_from);
    
    $interval=$interval->format('%a'); 
  if ($interval > '31')
  {
  $_SESSION['interval'] = 'inerval';  
        header("Location: \order_deliver.php");      
    exit;
  }   
$date_from = $_POST['date_from'].' 00:00:00';
$date_by = $_POST['date_by'].' 23:59:59';
 # echo  $date_from, $date_by;   

  if ($date_from > $date_by)
  {
  $_SESSION['Nocorrectdate'] = $date_by;  
        header("Location: \order_deliver.php");      
    exit;
  } 
  $city=$_POST['city'];
  $type=$_POST['parcell'];

   
     if ($type=='Zakazy')
  {
  $_SESSION['tip'] = $type;  
        header("Location: \order_deliver.php");      
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
$sheet->setTitle($city.'_'.$type);
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:K1');
$sheet->getStyle('A1')->getFont()->setSize(12);
$sheet->getStyle('A1:K1')->getFont()->setBold(true);   
$date = date('Y-m-d_H:i');
$sheet->setCellValue('A1', 'Интервал с '.$date_from.' по '.$date_by);
$sheet->setCellValue('A2','Населенный пункт отправки');
$sheet->setCellValue('B2','Маршрут');
$sheet->setCellValue('C2','Номер накладной');
$sheet->setCellValue('D2','Населенный пункт доставки');
$sheet->setCellValue('E2','НП из источника');
$sheet->setCellValue('F2','Адрес Доставки');
$sheet->setCellValue('G2','Фактический Вес');
$sheet->setCellValue('H2','Объемный Вес');
$sheet->setCellValue('I2','Дата доставки');
$sheet->setCellValue('J2','Дата получения груза у перевозчика');
$sheet->setCellValue('K2','Дата сканирования');
$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);  
$sheet->getColumnDimension('H')->setAutoSize(true); 
$sheet->getColumnDimension('I')->setAutoSize(true); 
$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->getColumnDimension('K')->setAutoSize(true);  
 
 
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);

$sheet->getStyle('A2:K2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:K2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:K2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

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
$sheet->getStyle('A2:K2')->getFont()->setBold(true);                    
$row1=3;  
       if ($city=='MO')
  {
  
         $result = mysql_query("SELECT b.Name as city_from, hbc_routes.Name as route,
                             d15_departures.WayBillNum as WaybillNum, hbc_cities.Name as city_to, d00_buff.str28,
                             d15_departures.R_Addr as address, d15_departures.Sh_Weight as Weight, 
                             d15_departures.Sh_VWeight as VWeight,
                             d20_extask.ExTimeStamp as deliver_date,
                             d50_vo.lCargoReceived as Carrier_date, d56vo2departure.SY_LastEdit as scan_date
                             FROM d20_extask 
                             left join d15_departures on d20_extask.dXXID=d15_departures.ID 
                             left join d21_extasklist on d20_extask.d21ID=d21_extasklist.ID
                             left join hbc_routes on hbc_routes.ID=d15_departures.R_RouteID
                             left join hbc_cities on hbc_cities.ID=d15_departures.R_CityID
                             left join hbc_divisions on hbc_divisions.ID=d15_departures.FromDivID
                             left join hbc_cities b on b.ID=hbc_divisions.CityID
                             left join d00_buff on d00_buff.dXXID=d15_departures.ID
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
         $str28=$row['str28'];
         $address=$row['address'];
         $weight=$row['Weight'];
         $vweight=$row['VWeight'];
         $deliver_date=$row['deliver_date'];
         $Carrier_date=$row['Carrier_date'];
         $scan_date=$row['scan_date'];
         
         $city_from=iconv("cp1251", "utf-8", $city_from); 
         $city_to=iconv("cp1251", "utf-8", $city_to); 
         $str28=iconv("cp1251", "utf-8", $str28);
         $address=iconv("cp1251", "utf-8", $address);

         $WaybillNum=iconv("cp1251", "utf-8", $WaybillNum);
                                       
    $sheet->setCellValueByColumnAndRow(0, $row1, $city_from);
    $sheet->setCellValueByColumnAndRow(1, $row1, $route);
    $sheet->setCellValueByColumnAndRow(2, $row1, $WaybillNum);  
    $sheet->setCellValueByColumnAndRow(3, $row1, $city_to);
    $sheet->setCellValueByColumnAndRow(4, $row1, $str28); 
    $sheet->setCellValueByColumnAndRow(5, $row1, $address);
    $sheet->setCellValueByColumnAndRow(6, $row1, $weight);
    $sheet->setCellValueByColumnAndRow(7, $row1, $vweight);
    $sheet->setCellValueByColumnAndRow(8, $row1, $deliver_date);
    $sheet->setCellValueByColumnAndRow(9, $row1, $Carrier_date);                                      
    $sheet->setCellValueByColumnAndRow(10, $row1, $scan_date);
                                       
                               $row1++;         
                                                           }
                                                           }                  
   else {   
                   $result = mysql_query("SELECT b.Name as city_from, hbc_routes.Name as route,
                             d15_departures.WayBillNum as WaybillNum, hbc_cities.Name as city_to,  d00_buff.str28,
                             d20_extask.Addr as address,  d15_departures.Sh_Weight as Weight, 
                             d15_departures.Sh_VWeight as VWeight,
                             d20_extask.ExTimeStamp as deliver_date,
                             d50_vo.lCargoReceived as Carrier_date, d56vo2departure.SY_LastEdit as scan_date
                             FROM d20_extask 
                             left join d15_departures on d20_extask.dXXID=d15_departures.ID 
                             left join d21_extasklist on d20_extask.d21ID=d21_extasklist.ID
                             left join hbc_routes on hbc_routes.ID=d15_departures.R_RouteID
                             left join hbc_cities on hbc_cities.ID=d15_departures.R_CityID
                             left join hbc_divisions on hbc_divisions.ID=d15_departures.FromDivID
                             left join hbc_cities b on b.ID=hbc_divisions.CityID
                             left join d00_buff on d00_buff.dXXID=d15_departures.ID
                             left join d56vo2departure on d15_departures.ID=d56vo2departure.d15ID
                             left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                             left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                             left join d50_vo on d30_manifests.d50ID=d50_vo.ID

                             where d15_departures.ToDivID='1'  and d20_extask.stateKey='7' and hbc_routes.Name is not NULL 
                             and d15_departures.SY_Void=0 and d15_departures.PickUpCode is NULL and hbc_routes.Name not like 'BH%' 
                             and hbc_routes.Name not in ('C-P', 'H-A') and d20_extask.cpPost <> 'Уничтожено'
                             and hbc_routes.Name not like 'MO%' and d20_extask.ExTimeStamp between '$date_from' and '$date_by'
                             group by d15_departures.WayBillNum");  
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
       
         $city_from=$row['city_from'];
         $route=$row['route'];
         $WaybillNum=$row['WaybillNum'];
         $city_to=$row['city_to']; 
         $str28=$row['str28'];
         $address=$row['address'];
         $weight=$row['Weight'];
         $vweight=$row['VWeight'];
         $deliver_date=$row['deliver_date'];
         $Carrier_date=$row['Carrier_date'];
         $scan_date=$row['scan_date'];
         
         $city_from=iconv("cp1251", "utf-8", $city_from); 
         $city_to=iconv("cp1251", "utf-8", $city_to); 
         $str28=iconv("cp1251", "utf-8", $str28);
         $address=iconv("cp1251", "utf-8", $address);

         $WaybillNum=iconv("cp1251", "utf-8", $WaybillNum);
                                       
    $sheet->setCellValueByColumnAndRow(0, $row1, $city_from);
    $sheet->setCellValueByColumnAndRow(1, $row1, $route);
    $sheet->setCellValueByColumnAndRow(2, $row1, $WaybillNum);  
    $sheet->setCellValueByColumnAndRow(3, $row1, $city_to);
    $sheet->setCellValueByColumnAndRow(4, $row1, $str28); 
    $sheet->setCellValueByColumnAndRow(5, $row1, $address);
    $sheet->setCellValueByColumnAndRow(6, $row1, $weight);
    $sheet->setCellValueByColumnAndRow(7, $row1, $vweight);
    $sheet->setCellValueByColumnAndRow(8, $row1, $deliver_date);
    $sheet->setCellValueByColumnAndRow(9, $row1, $Carrier_date);                                      
    $sheet->setCellValueByColumnAndRow(10, $row1, $scan_date);
                                       
                               $row1++; }                                                         }
   
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
  