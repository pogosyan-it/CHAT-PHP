<?php

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
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Подписываем лист
$sheet->setTitle('3-й город');
$sheet->getDefaultStyle()->getFont()->setSize(12); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:F1');
$date = date('Y-m-d');

$sheet->setCellValue('A1', '3-й Город');
$sheet->setCellValue('A2', '№');
$sheet->setCellValue('B2','№ Заказа');
$sheet->setCellValue('C2','№ Накладной');
$sheet->setCellValue('D2','Маршрут');
$sheet->setCellValue('E2','Офис доставки');
$sheet->setCellValue('F2','Офис оплаты');

$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setAutoSize(true); 
$sheet->getColumnDimension('F')->setAutoSize(true); 
$sheet->getColumnDimension('G')->setAutoSize(true);  

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
$row1=3;  
$index=0;
     $result = mysqli_query($link, "Select d15_departures.PickUpCode, d15_departures.WayBillNum, hbc_routes.Name as r_route, hbc_divisions.Name as div_name,  
                              d15_departures.PaymentTXT, hbc_cities.Name as city_name
                                   from  d15_departures 
                              left join hbc_divisions on hbc_divisions.ID=d15_departures.ToDivID
                              left join hbc_cities on hbc_cities.ID=hbc_divisions.CityID
                              left join hbc_routes on hbc_routes.ID=d15_departures.S_RouteID
                              
                              where d15_departures.SY_Void=0  and d15_departures.PickUpCode is not null and
										
                              Date_Format(d15_departures.PickUpRTime, '%Y-%m-%d')=Date_Format(NOW(), '%Y-%m-%d') 
                              and d15_departures.SY_OwnDiv<>d15_departures.ToDivID and d15_departures.FromDivID=1
                              or
                              d15_departures.PickUpCode is not null and  
                              Date_Format(d15_departures.PickUpRTime, '%Y-%m-%d')=Date_Format(NOW(), '%Y-%m-%d')  and d15_departures.SY_Void=0 and
                              SUBSTRING_INDEX(hbc_cities.Name, '(', 1)<>d15_departures.PaymentTXT and d15_departures.FromDivID=1 and 
                              d15_departures.SY_OwnDiv=d15_departures.ToDivID 
                              order by hbc_routes.Name"); 
     while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
         
         $row[1]=iconv("cp1251", "utf-8", $row[1]);         
         $row[2]=iconv("cp1251", "utf-8", $row[2]);
         $row[3]=iconv("cp1251", "utf-8", $row[3]);
         $row[4]=iconv("cp1251", "utf-8", $row[4]);       
         $row[5]=iconv("cp1251", "utf-8", $row[5]);
         $th_city=iconv("utf-8", "cp1251", '3-Й ГОРОД ');
         
# $row[0]номер заказа    $row[1]№ накладной    $row[2]hbc_routes.Name    $row[3]hbc_divisions.Name    $row[4]PaymentTXT.   $row[5]hbc_cities.Name       
                   
                   if  ($row[1] !== 'Снят!' and $row[4] !== 'КОРП' or $row[4] == 'КОРП' and $row[5] !== 'Москва' and $row[1] !== 'Снят!')                 
                      {     
                             
                            $res =mysqli_query($link, "Select d15_departures.Sh_Demensions from d15_departures where d15_departures.PickUpCode='$row[0]';");
                                       while ($row2 = mysqli_fetch_array($res, MYSQLI_ASSOC))     {
                                       $dem=iconv("cp1251", "utf-8", $row2['Sh_Demensions']);
                                       $test=preg_match("(город)", mb_strtolower($dem));                                                          
                                     if ($test==0) {                                                            
                             $dem=iconv("utf-8", "cp1251", $dem);
                             $result2 =mysqli_query($link, "Select Concat('$th_city', '$dem') into @param;");
                             $result3=mysqli_query($link, "Update d15_departures SET d15_departures.Sh_Demensions=@param where d15_departures.PickUpCode='$row[0]';");
                                                   }
                                      else {$index=$index-1;}             
                                         $index++;  
                                        }   
                                                      $row[0]=iconv("cp1251", "utf-8", $row[0]);
                                                      $sheet->setCellValueByColumnAndRow(0, $row1, $row1-2);
                                                      $sheet->setCellValueByColumnAndRow(1, $row1, $row[0]);
                                                      $sheet->setCellValueByColumnAndRow(2, $row1, $row[1]);
                                                      $sheet->setCellValueByColumnAndRow(3, $row1, $row[2]);  
                                                      $sheet->setCellValueByColumnAndRow(4, $row1, $row[3]);
                                                      $sheet->setCellValueByColumnAndRow(5, $row1, $row[4]);
                       }
                           else {$row1=$row1-1;}
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
 $objWriter->save("/var/www/files/3th_city/$date.xls"); 

// Echo memory usage        
  