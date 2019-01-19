<?php
 session_start();
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  

   if(!preg_match('[\d] ', $_POST['date_from']) or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \Cartridge.php");      
    exit;
  }
$date_from = $_POST['date_from'].' 00:00:00';
$date_by = $_POST['date_by'].' 23:59:59';
 # echo  $date_from, $date_by;   

  if ($date_from > $date_by)
  {
  $_SESSION['Nocorrectdate'] = $date_by;  
        header("Location: \Cartridge.php");      
    exit;
  } 
function connect()
{ // BEGIN function connect
	mysql_connect("10.10.1.2", "root", "2me32jvppn");
  mysql_set_charset("CP1251");
  mysql_select_db("Cartriges");
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
$sheet->setTitle('Картриджи');
$sheet->getDefaultStyle()->getFont()->setSize(14); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:E1');
$date = date('Y-m-d_H:i');
$sheet->setCellValue('A1', 'Интервал с '.$date_from.' по '.$date_by);
$sheet->setCellValue('A2','Модель принтера');
$sheet->setCellValue('B2','Картридж');
$sheet->setCellValue('C2','Количество');
$sheet->setCellValue('D2','Цена');
$sheet->setCellValue('E2','Сумма');

#$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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

#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);

$sheet->getStyle('A2:E2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:E2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:E2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:E2')->getFont()->setBold(true);                    
$row1=3; 
$myresult=array();              
#$index=0;
$sum=0;  
        
         $result = mysql_query("Select Cartrige_model, SUM(quantity) as quantity, Price, SUM(Price*quantity) as summ, Printers.printer_model from Cartrige_price 
                                left join General on General.id_printer=Cartrige_price.printer_id
                                left join Printers on Printers.id=Cartrige_price.printer_id
                                where General.date between '$date_from' and '$date_by' group by Cartrige_price.Cartrige_model");  
     while ($row = mysql_fetch_array($result, MYSQL_BOTH)) {
         $M_Printer=$row['printer_model'];
         $M_Cartrige=$row['Cartrige_model'];
         $quantity=$row['quantity'];
         $Price=$row['Price'];
         $summ=$row['summ'];
         $myresult[$row1]=$row[3];
                   #index++;
        # $address=iconv("cp1251", "utf-8", $address);
    $sheet->setCellValueByColumnAndRow(0, $row1, $M_Printer);                                  
    $sheet->setCellValueByColumnAndRow(1, $row1, $M_Cartrige);
    $sheet->setCellValueByColumnAndRow(2, $row1, $quantity);
    $sheet->setCellValueByColumnAndRow(3, $row1, $Price);  
    $sheet->setCellValueByColumnAndRow(4, $row1, $summ);
                                        
                               $row1++;         
                                                        
                                                           }                  
#$formula = '=SUM(D2:D5)';
foreach ($myresult as $item) {
        #print($item)."</br>";
        
        $sum=$sum+$item;
}   
$arg='A'.$row1.':'.'E'.$row1;                                                                   
 $sheet->getStyle($arg)->getFont()->setBold(true); 
 $sheet->setCellValueByColumnAndRow(0, $row1, 'Всего:');
 $sheet->setCellValueByColumnAndRow(4, $row1, $sum);     
#$sheet->setCellValue('D10', $formula);
   
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
  