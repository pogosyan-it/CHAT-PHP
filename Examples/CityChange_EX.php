<?php
 session_start();
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['CityChange'])){
     header("Location: \Menu.php");
     exit;                    }  
if(empty($_SESSION['Obl']))
  {
 # $_SESSION['NoObl'] = 'NoObl';  
         header("Location: \CityChange.php");     
    exit;
  }
  
  $oblID=$_SESSION['Obl'];

function connect()
{ // BEGIN function connect
	mysql_connect("10.10.1.2", "root", "2me32jvppn");
  mysql_set_charset("CP1251");
  mysql_select_db("gsotldb");
  mysql_query("SET NAMES 'CP1251'");
} // END function connect  
   
  connect();   
$result = mysql_query("select Name  from hbc_fedunits   where ID=$oblID");  
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
               $oblName=$row['Name'];                      
         $oblName=iconv("cp1251", "utf-8", $oblName); 
                                                            }  
      
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
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Подписываем лист
$sheet->setTitle($oblName);
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:F1');
$sheet->getStyle('A1')->getFont()->setSize(12);
$sheet->getStyle('A1:F1')->getFont()->setBold(true);   
$date = date('Y-m-d_H:i');
$sheet->setCellValue('A1', $oblName);
$sheet->setCellValue('A2','ID');
$sheet->setCellValue('B2','НП');
$sheet->setCellValue('C2','Область');
$sheet->setCellValue('D2','Тип');
$sheet->setCellValue('E2','Маршрут');
$sheet->setCellValue('F2','Зона');

$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
 
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);

$sheet->getStyle('A2:F2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:F2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:F2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2:F2')->getFont()->setBold(true);                    
$row1=3;  
  
 $result = mysql_query("select hbc_cities.ID, hbc_cities.Name, hbc_fedunits.Name as obl, hbc_fedunittypes.Name  as type, hbc_routes.Name as route, hbc_zones.Name as zname
                        from hbc_cities
                        left join hbc_fedunits on hbc_cities.FedUnitID=hbc_fedunits.ID
                        left join hbc_routes on hbc_cities.RouteUIN=hbc_routes.ID
                        left join hbc_fedunittypes on hbc_cities.UnitTypeID=hbc_fedunittypes.ID
                        left join hbc_zones on hbc_zones.ID=hbc_cities.ZoneID
                        where hbc_fedunits.ID=$oblID");  
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
       
         $ID=$row['ID'];
         $Name=$row['Name'];
         $obl=$row['obl'];
         $type=$row['type'];
         $route=$row['route'];
         $Zone=$row['zname'];
                 
         $Name=iconv("cp1251", "utf-8", $Name); 
         $obl=iconv("cp1251", "utf-8", $obl); 
         $type=iconv("cp1251", "utf-8", $type);
                                         
    $sheet->setCellValueByColumnAndRow(0, $row1, $ID);
    $sheet->setCellValueByColumnAndRow(1, $row1, $Name);
    $sheet->setCellValueByColumnAndRow(2, $row1, $obl);  
    $sheet->setCellValueByColumnAndRow(3, $row1, $type);
    $sheet->setCellValueByColumnAndRow(4, $row1, $route);
    $sheet->setCellValueByColumnAndRow(5, $row1, $Zone);  
                                       
                               $row1++;         
                                                           }
                                     
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
  