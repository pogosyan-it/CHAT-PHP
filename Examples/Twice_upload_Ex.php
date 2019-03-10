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
$sheet->setTitle('Доставки');
$sheet->getDefaultStyle()->getFont()->setSize(12); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:J1');
$date = date('Y-m-d');

$sheet->setCellValue('A1', 'Повторная закачка');
$sheet->setCellValue('A2', 'Номер Накладной');
$sheet->setCellValue('B2', 'Дата закачки');
$sheet->setCellValue('C2','Город офиса заказа');
$sheet->setCellValue('D2','Город офиса исполнения');
$sheet->setCellValue('E2','Город офиса доставки');
$sheet->setCellValue('F2','Населенный пункт');
$sheet->setCellValue('G2','Страна');
$sheet->setCellValue('H2','Область, край');
$sheet->setCellValue('I2','Название улицы');
$sheet->setCellValue('J2','ДУ СУ');

$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setAutoSize(true); 
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);  
$sheet->getColumnDimension('I')->setAutoSize(true); 
$sheet->getColumnDimension('J')->setAutoSize(true);

#$sheet->getColumnDimension('G')->setAutoSize(true);  

$sheet->getStyle('A2:J2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:J2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:J2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A1:J1')->getFont()->setBold(true);
$sheet->getStyle('A2:J2')->getFont()->setBold(true);   

$xls->createSheet();     
$xls->setActiveSheetIndex(1);
$sheet1 = $xls->getActiveSheet();
$sheet1->getPageSetup()
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet1->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Подписываем лист
$sheet1->setTitle('Заказы');
$sheet1->getDefaultStyle()->getFont()->setSize(12); 
$sheet1->getPageMargins()->setTop(0);
$sheet1->getPageMargins()->setRight(0.4);
$sheet1->getPageMargins()->setLeft(0.5);
$sheet1->getPageMargins()->setBottom(0);
$sheet1->mergeCells('A1:R1');

$sheet1->setCellValue('A1', 'Повторная закачка');
$sheet1->setCellValue('A2', 'Номер Заказа');
$sheet1->setCellValue('B2', 'Дата Закачки');
$sheet1->setCellValue('C2', 'Город офиса заказа');
$sheet1->setCellValue('D2','Страна');
$sheet1->setCellValue('E2','Город');
$sheet1->setCellValue('F2','Тип улицы');
$sheet1->setCellValue('G2','Название улицы');
$sheet1->setCellValue('H2','Дом');
$sheet1->setCellValue('I2','Город офиса Доставки');
$sheet1->setCellValue('J2','Населенный пункт Получения');
$sheet1->setCellValue('K2','Дата');
$sheet1->setCellValue('L2','Время');
$sheet1->setCellValue('M2','Оплата товара');
$sheet1->setCellValue('N2','Условия получения');
$sheet1->setCellValue('O2','Требования к упаковке');
$sheet1->setCellValue('P2','ДУ СУ');
$sheet1->setCellValue('Q2','Примечание');
$sheet1->setCellValue('R2','Вид Услуги');

$sheet1->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet1->getColumnDimension('A')->setAutoSize(true);
$sheet1->getColumnDimension('B')->setAutoSize(true);
$sheet1->getColumnDimension('C')->setAutoSize(true);
$sheet1->getColumnDimension('D')->setAutoSize(true);  
$sheet1->getColumnDimension('E')->setAutoSize(true); 
$sheet1->getColumnDimension('F')->setAutoSize(true);
$sheet1->getColumnDimension('G')->setAutoSize(true);
$sheet1->getColumnDimension('H')->setAutoSize(true);  
$sheet1->getColumnDimension('I')->setAutoSize(true); 
$sheet1->getColumnDimension('J')->setAutoSize(true);
$sheet1->getColumnDimension('K')->setAutoSize(true);
$sheet1->getColumnDimension('L')->setAutoSize(true);  
$sheet1->getColumnDimension('M')->setAutoSize(true); 
$sheet1->getColumnDimension('N')->setAutoSize(true);
$sheet1->getColumnDimension('O')->setAutoSize(true);
$sheet1->getColumnDimension('P')->setAutoSize(true); 
$sheet1->getColumnDimension('P')->setAutoSize(true); 
$sheet1->getColumnDimension('R')->setAutoSize(true);

$sheet1->getStyle('A2:R2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('A2:R2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('A2:R2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('A2:R2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet1->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('G2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('H2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('I2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('K2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('M2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('N2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('O2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('P2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('Q2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('R2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('A1:R1')->getFont()->setBold(true);
$sheet1->getStyle('A2:R2')->getFont()->setBold(true); 

$xls->createSheet();     
$xls->setActiveSheetIndex(2);
$sheet2 = $xls->getActiveSheet();
$sheet2->getPageSetup()
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet2->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Подписываем лист
$sheet2->setTitle('Транзиты');
$sheet2->getDefaultStyle()->getFont()->setSize(12); 
$sheet2->getPageMargins()->setTop(0);
$sheet2->getPageMargins()->setRight(0.4);
$sheet2->getPageMargins()->setLeft(0.5);
$sheet2->getPageMargins()->setBottom(0);
$sheet2->mergeCells('A1:M1');

$sheet2->setCellValue('A1', 'Повторная закачка');
$sheet2->setCellValue('A2', 'Номер Накладной');
$sheet2->setCellValue('B2', 'Дата Закачки');
$sheet2->setCellValue('C2', 'Дата Отправления');
$sheet2->setCellValue('D2','Город Отправления');
$sheet2->setCellValue('E2','Населенный пункт');
$sheet2->setCellValue('F2','Респ. обл. Край');
$sheet2->setCellValue('G2','Район');
$sheet2->setCellValue('H2','Город офиса Доставки');
$sheet2->setCellValue('I2','Населенный пункт Получения');
$sheet2->setCellValue('J2','Респ. обл. Край');
$sheet2->setCellValue('K2','Район');
$sheet2->setCellValue('L2','Примечание');
$sheet2->setCellValue('M2','Вид Услуг');

$sheet2->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet2->getColumnDimension('A')->setAutoSize(true);
$sheet2->getColumnDimension('B')->setAutoSize(true);
$sheet2->getColumnDimension('C')->setAutoSize(true);
$sheet2->getColumnDimension('D')->setAutoSize(true);  
$sheet2->getColumnDimension('E')->setAutoSize(true); 
$sheet2->getColumnDimension('F')->setAutoSize(true);
$sheet2->getColumnDimension('G')->setAutoSize(true);
$sheet2->getColumnDimension('H')->setAutoSize(true);  
$sheet2->getColumnDimension('I')->setAutoSize(true); 
$sheet2->getColumnDimension('J')->setAutoSize(true);
$sheet2->getColumnDimension('K')->setAutoSize(true);
$sheet2->getColumnDimension('L')->setAutoSize(true); 
$sheet2->getColumnDimension('M')->setAutoSize(true); 


$sheet2->getStyle('A2:L2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('A2:L2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('A2:L2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('A2:L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet2->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('G2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('H2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('I2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('K2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet2->getStyle('M2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet2->getStyle('A1:M1')->getFont()->setBold(true);
$sheet2->getStyle('A2:M2')->getFont()->setBold(true);



$index=3;
$index2=3;
$index3=3;
$index1=0;
     $result = mysqli_query($link,  "Select NOW() - Interval 1 day into @t;"); 
                                    
     $result = mysqli_query($link, "Select d15_departures.WayBillNum, d15_departures.PickUpCode,
                                    d15_departures.SY_Adding, d00_buff.SY_LastEdit, d15_departures.ToDivID, d15_departures.FromDivID, d00_buff.str04
                                    from d15_departures
                                    left join d00_buff on d00_buff.dXXID=d15_departures.ID
                                    where UNIX_TIMESTAMP(d00_buff.SY_LastEdit) - UNIX_TIMESTAMP(d15_departures.SY_Adding ) > '86400'
                                    and d00_buff.SY_LastEdit>@t and d15_departures.WayBillNum not like '%!' and d15_departures.SY_Void=0;"); 
                                    

              while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                      if ($row[5]=='1')             // Заказы
                          { $res1 = mysqli_query($link,    "Select d00_buff.str04, d00_buff.SY_Adding, d00_buff.str03, d00_buff.str13, d00_buff.str12, d00_buff.str16, 
                                                           d00_buff.str17, d00_buff.str18, d00_buff.str27, d00_buff.str28, d00_buff.str50, 
                                                           d00_buff.str51, d00_buff.str52, d00_buff.str53, d00_buff.str59, d00_buff.str67, d00_buff.str68 
                                                           from d00_buff where d00_buff.str04='$row[1]';");
                                 while ($row1 = mysqli_fetch_array($res1, MYSQL_NUM)) 
                                 {
                                             for ($j = 0; $j <= 16; $j++)   {
                                             $row1[$j]=iconv("cp1251", "utf-8", $row1[$j]);         
                                                 if ($j!=13) {
                                                              
                                                              $sheet1->setCellValueByColumnAndRow($j, $index, $row1[$j]);
                                                              }
                                                                            }
                                        $index++;                                             
                                 }  
                                       
                                   } 
                       elseif ($row[4]=='1' and empty($row[6]))                // Доставки
                                        {
                                          $res2 = mysqli_query($link, "Select d00_buff.str01, d00_buff.SY_Adding, d00_buff.str03,  d00_buff.str07,
                                                                       d00_buff.str27, d00_buff.str28, d00_buff.str29, d00_buff.str30, d00_buff.str33
                                                                       from d00_buff where d00_buff.str01='$row[0]';");
                                 while ($row2 = mysqli_fetch_array($res2, MYSQL_NUM))                        
                      
                                 {
                                 
                                            for ($q = 0; $q <= 8; $q++)   {
                                             $row2[$q]=iconv("cp1251", "utf-8", $row2[$q]);         
                                             $sheet->setCellValueByColumnAndRow($q, $index2, $row2[$q]);
                                                                         }
                                    
                                              
                                              $index2++;
                                        }            
                    
                                                    
                    }  
                      elseif ($row[4]!='1' and $row[5]!='1')    //Транзиты
                    {
                                          $res3 = mysqli_query($link, "Select d00_buff.str01, d00_buff.SY_Adding, d00_buff.str02, d00_buff.str07,  d00_buff.str12, d00_buff.str14, d00_buff.str15,
                                                                       d00_buff.str27, d00_buff.str28, d00_buff.str30, d00_buff.str31, d00_buff.str67, d00_buff.str68
                                                                       from d00_buff where d00_buff.str01='$row[0]';");
                                 while ($row3 = mysqli_fetch_array($res3, MYSQL_NUM))                        
                      
                                 {
                                 
                                            for ($k = 0; $k <= 12; $k++)   {
                                             $row3[$k]=iconv("cp1251", "utf-8", $row3[$k]);         
                                             $sheet2->setCellValueByColumnAndRow($k, $index3, $row3[$k]);
                                                                           }
                                    
                                              
                                              $index3++;
                                 }            
                    
                                    
                    }      
                        
                         $index1++;
                     
                      }

 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=$date.xls" );
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 $objWriter->save("/var/www/files/Upload/$date.xls"); 
$out = shell_exec('echo "См. вложение" | mail -s \'Дважды закаченные заказы доставки транзиты\' -a /var/www/files/Upload/`date +%Y-%m-%d`.xls -r "gsot@corp.ws" smk@dmcorp.ru'); 
$out = shell_exec('echo "См. вложение" | mail -s \'Дважды закаченные заказы доставки транзиты\' -a /var/www/files/Upload/`date +%Y-%m-%d`.xls -r "gsot@corp.ws" boss-iao@dmcorp.ru');                                      

// Выводим HTTP-заголовки

// Echo memory usage        
  