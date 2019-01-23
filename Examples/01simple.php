<?php
 session_start();
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  

  $Login = $_SESSION['login'];
 # $send = $_SESSION['send'];
    
  function connect()
{ // BEGIN function connect
	mysql_connect("10.10.1.2", "root", "2me32jvppn");
  mysql_set_charset("cp1251");
  mysql_select_db("gsotldb");
  mysql_query("SET NAMES 'cp1251'");
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

$res = mysql_query("Select hb_employee.SName from hb_employee where hb_employee.login='$Login'");
        while ($row = mysql_fetch_array($res, MYSQL_ASSOC))
           {
						   $send=$row['SName'];
              
					   }
             $sending=iconv("cp1251", "utf-8", $send);       
  
  $result1 =  mysql_query("Select id from hb_employee where hb_employee.Login='$Login' into @emp_id;") ;                 
// Создаем объект класса PHPExcel
$xls = new PHPExcel();
// Устанавливаем индекс активного листа
$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();
// Подписываем лист
$sheet->setTitle('Реестр');
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:D1');
$sheet->mergeCells('A2:D2');
$date = date('d-m-Y H:i');
$sheet->setCellValue('A1',$date);
$sheet->setCellValue('A3','№');
$sheet->setCellValue('C3','Накладная');
$sheet->setCellValue('B3','Дата/время создания');
$sheet->setCellValue('D3','Отметка наличия');
$sheet->getColumnDimension('B')->setAutoSize(true); 
$sheet->getColumnDimension('C')->setAutoSize(true); 
$sheet->getColumnDimension('D')->setAutoSize(true);
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);
$sheet->getStyle('A3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:D3')->getFont()->setBold(true);
#$sheet->getStyle('A1')->getFont()->setBold(true);


$result =  mysql_query("Select d15_departures.WayBillNum from d15_departures where d15_departures.SY_Empl=@emp_id and d15_departures.FromDivID='1' and d15_departures.fSidePost='1'
and d15_departures.SY_Void='0' and d15_departures.SY_Adding > (Select NOW() - Interval 12 hour)") ;                 
$row = 4;
$col = 1;
while ($row_data = mysql_fetch_assoc($result))      {

foreach($row_data as $key=>$value) {
        $sheet->setCellValueByColumnAndRow(2, $row, $value);
        
        $col++;
                                   }
    $row++;
                                                  }
                                                  
$result =  mysql_query("Select d15_departures.SY_Adding from d15_departures where d15_departures.SY_Empl=@emp_id and d15_departures.FromDivID='1' and d15_departures.fSidePost='1'
and d15_departures.SY_Void='0' and d15_departures.SY_Adding > (Select NOW() - Interval 12 hour)") ;                 
$row = 4;
$col = 0;
while ($row_data = mysql_fetch_assoc($result))      {

foreach($row_data as $key=>$value) {
        $sheet->setCellValueByColumnAndRow(1, $row, $value);
        
        $col++;
                                   }
    $row++;
                                                  }
                                                  
for ($i = 4; $i < $col+4; $i++)     {
    
$sheet->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('D'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                          }

     for ($j = 4; $j < $col+4; $j++) {
    

         $sheet->setCellValueByColumnAndRow(0, $j, $j-3);
$sheet->getStyle('A'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$j)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('C'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                      }
                                      
    
$sheet->setCellValueByColumnAndRow(0, $col+6, 'Сдал');
$sheet->setCellValueByColumnAndRow(0, $col+7,'Принял');
$sheet->setCellValueByColumnAndRow(1, $col+5,'ФИО');
$sheet->setCellValueByColumnAndRow(2, $col+5,'Подпись');
$sheet->getStyle('A'.($col+6))->getFont()->setBold(true); 
$sheet->getStyle('A'.($col+7))->getFont()->setBold(true);
$sheet->getStyle('B'.($col+5))->getFont()->setBold(true);
$sheet->getStyle('C'.($col+5))->getFont()->setBold(true);  
$sheet->setCellValue('B'.($col+6),$sending); 
 
 for ($q = $col+5; $q < $col+8; $q++) {
    
        // Выводим таблицу умножения
$sheet->getStyle('A'.$q)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$q)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$q)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$q)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$q)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$q)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$q)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$q)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$q)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$q)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                      }
 
   
$sheet->getStyle('A1:D1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:D1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:D1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:D1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2:D2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:D2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
 
// Выводим HTTP-заголовки
 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=$Login.xls" );

// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 $objWriter->save('php://output'); 

// Echo memory usage
