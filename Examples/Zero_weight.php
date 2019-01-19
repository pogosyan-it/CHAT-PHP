<?php

include '/var/www/gsotldb.php';
          
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
$sheet->setTitle('0-Й ВЕС');
$sheet->getDefaultStyle()->getFont()->setSize(12); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:F1');
$date = date('Y-m-d');

$sheet->setCellValue('A1', 'Накладные с 0-м весом');
$sheet->setCellValue('A2', '№');
$sheet->setCellValue('B2','№ Накладной');
$sheet->setCellValue('C2','№ Заказа');
$sheet->setCellValue('D2','Дата');
$sheet->setCellValue('E2','Офис отправления');
$sheet->setCellValue('F2','Офис Получения');

$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setAutoSize(true); 
$sheet->getColumnDimension('F')->setAutoSize(true); 
#$sheet->getColumnDimension('G')->setAutoSize(true);  

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

$sheet->getStyle('A1:F1')->getFont()->setBold(true);
$sheet->getStyle('A2:F2')->getFont()->setBold(true);                    

$index=3;
     $result = mysqli_query($link, "Select NOW() into @t2;"); 
     $result = mysqli_query($link, "Select NOW() - Interval 30 day into @t1;");                                
     $result = mysqli_query($link, "select d15_departures.WayBillNum, d15_departures.PickUpCode, d15_departures.SY_Adding, hbc_divisions.Name, a.Name from d15_departures
                                    left join hbc_divisions on hbc_divisions.ID=d15_departures.FromDivID
                                    left join hbc_divisions a on a.ID=d15_departures.ToDivID
                                    where d15_departures.Sh_Weight=0 and d15_departures.SY_Void=0 
                                    and d15_departures.WayBillNum not like '%!' and d15_departures.SY_Adding between @t1 and @t2;"); 
                                    
     if(mysqli_num_rows($result) > 0)
{
     
     while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
         
         $row[1]=iconv("cp1251", "utf-8", $row[1]);         
         $row[2]=iconv("cp1251", "utf-8", $row[2]);
          
          $row[0]=iconv("cp1251", "utf-8", $row[0]);
          $sheet->setCellValueByColumnAndRow(0, $index, $index-2);
          $sheet->setCellValueByColumnAndRow(1, $index, $row[0]);
          $sheet->setCellValueByColumnAndRow(2, $index, $row[1]);
          $sheet->setCellValueByColumnAndRow(3, $index, $row[2]);  
          $sheet->setCellValueByColumnAndRow(4, $index, $row[3]);
          $sheet->setCellValueByColumnAndRow(5, $index, $row[4]);
                      
                           
                               $index++;         
                                                                 
                                                            }
   header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=$date.xls" );

// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 $objWriter->save("/var/www/files/Quality/$date.xls"); 
 $out = shell_exec('echo "См. вложение" | mail -s \'Нулевые Веса\' -a /var/www/files/Quality/`date +%Y-%m-%d`.xls -r "gsot@corp.ws" boss-iao@dmcorp.ru');  
 $out = shell_exec('echo "См. вложение" | mail -s \'Нулевые Веса\' -a /var/www/files/Quality/`date +%Y-%m-%d`.xls -r "gsot@corp.ws" gdannie@dmcorp.ru');
 $out = shell_exec('echo "См. вложение" | mail -s \'Нулевые Веса\' -a /var/www/files/Quality/`date +%Y-%m-%d`.xls -r "gsot@corp.ws" gsverki@dmcorp.ru');
 $out = shell_exec('echo "См. вложение" | mail -s \'Нулевые Веса\' -a /var/www/files/Quality/`date +%Y-%m-%d`.xls -r "gsot@corp.ws" smk@dmcorp.ru');                                                         
}
     else {
           $out = shell_exec('echo "Накладных с 0-м весом не найдено." | mail -s \'Нулевые Веса\' -r "gsot@corp.ws" boss-iao@dmcorp.ru');
           $out = shell_exec('echo "Накладных с 0-м весом не найдено." | mail -s \'Нулевые Веса\' -r "gsot@corp.ws" gdannie@dmcorp.ru');
           $out = shell_exec('echo "Накладных с 0-м весом не найдено." | mail -s \'Нулевые Веса\' -r "gsot@corp.ws" gsverki@dmcorp.ru');
           $out = shell_exec('echo "Накладных с 0-м весом не найдено." | mail -s \'Нулевые Веса\' -r "gsot@corp.ws" smk@dmcorp.ru');
          }
// Выводим HTTP-заголовки

// Echo memory usage        
  