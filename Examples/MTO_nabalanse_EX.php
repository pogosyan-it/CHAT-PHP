<?php
 session_start(); 
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['mto'])){
     header("Location: \Menu.php");
     exit;     }  
  
$link = new mysqli(
         "10.10.1.2",  // Хост, к которому мы подключаемся 
            "root",      // Имя пользователя  
            "2me32jvppn",    // Используемый пароль 
            "MTO");     // База данных для запросов по умолчанию  
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
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
#$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Подписываем лист
$sheet->setTitle('На балансе');
$sheet->getDefaultStyle()->getFont()->setSize(8);
#$sheet->getStyle("A3:S3")->getFont()->setSize(10);  
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0);
$sheet->getPageMargins()->setLeft(0);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:S1');
$sheet->mergeCells('A2:C2');
$sheet->mergeCells('D2:S2');
$date = date('Y-m-d_H-i');
$sheet->setCellValue('A1', 'Форменная одежда и инвентарь DIMEX');
$sheet->setCellValue('A2', 'Данные');
$sheet->setCellValue('D2', 'Выдано');
$sheet->setCellValue('A3', 'Ф.И.О.');
$sheet->setCellValue('B3', 'Рост');
$sheet->setCellValue('C3','Размер');
$sheet->setCellValue('D3','Дата');
$sheet->setCellValue('E3','Куртка демисезонная');
$sheet->setCellValue('F3','Дата');
$sheet->setCellValue('G3','Куртка зимняя');
$sheet->setCellValue('H3','Дата');
$sheet->setCellValue('I3','Толстовка');
$sheet->setCellValue('J3','Дата');
$sheet->setCellValue('K3','Поло');
$sheet->setCellValue('L3','Дата');
$sheet->setCellValue('M3','Рюкзак');
$sheet->setCellValue('N3','Дата');
$sheet->setCellValue('O3','Сумка');
$sheet->setCellValue('P3','Дата');
$sheet->setCellValue('Q3','Рулетка');
$sheet->setCellValue('R3','Дата');
$sheet->setCellValue('S3','Весы безмен ');


#$sheet->setCellValue('A4', '40 ');

$sheet->getStyle('A:AC')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1:AC1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('A1:AC1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A2:AC2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('A2:AC2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A3:AC3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('A3:AC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A4:AC4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle('A4:AC4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
#$sheet->getColumnDimension('A')->setAutoSize(true);

$sheet->getRowDimension(3)->setRowHeight(45);
#$sheet->getRowDimension(4)->setRowHeight(33);


$sheet->getStyle('A3:AC3')->getAlignment()->setWrapText(true);
$sheet->getStyle('A2:L2')->getAlignment()->setWrapText(true);
$sheet->getColumnDimension('A')->setWidth(24);
$sheet->getColumnDimension('B')->setWidth(8);
$sheet->getColumnDimension('C')->setWidth(8);
$sheet->getColumnDimension('D')->setWidth(10);
$sheet->getColumnDimension('E')->setWidth(8);
$sheet->getColumnDimension('F')->setWidth(10);
$sheet->getColumnDimension('G')->setWidth(8);
$sheet->getColumnDimension('H')->setWidth(10);
$sheet->getColumnDimension('I')->setWidth(9);
$sheet->getColumnDimension('J')->setWidth(10);
$sheet->getColumnDimension('K')->setWidth(6);
$sheet->getColumnDimension('L')->setWidth(10);
$sheet->getColumnDimension('M')->setWidth(7);
$sheet->getColumnDimension('N')->setWidth(10);
$sheet->getColumnDimension('O')->setWidth(7);
$sheet->getColumnDimension('P')->setWidth(10);
$sheet->getColumnDimension('Q')->setWidth(7);
$sheet->getColumnDimension('R')->setWidth(10);
$sheet->getColumnDimension('S')->setWidth(8);

$sheet->getStyle('A1:AC1')->getFont()->setBold(true);
$sheet->getStyle('A2:AC2')->getFont()->setBold(true);     
$sheet->getStyle('A3:AC3')->getFont()->setBold(true);               

$rowex=4;  
$result = mysqli_query($link,"select distinct Employee.ID, Employee.SName, Size.height, Size.size
                              from `Empl_hand-out`
                              left join Employee on Employee.ID=`Empl_hand-out`.Emp_id
                              left join Size on Size.ID=`Empl_hand-out`.id_size
                              left join Item on Item.ID=`Empl_hand-out`.id_item
                              group by Employee.ID"); 
                              while ($row = mysqli_fetch_array($result, MYSQL_NUM))    
                  {      
                        $IDEmpl=$row[0];                   
                        $row[1]=iconv("cp1251", "utf-8", $row[1]);               
                       $sheet->setCellValueByColumnAndRow(0, $rowex, $row[1]);
                       $sheet->setCellValueByColumnAndRow(1, $rowex, $row[2]);  
                       $sheet->setCellValueByColumnAndRow(2, $rowex, $row[3]);
  
$result1 = mysqli_query($link,"select date, id_item   from `Empl_hand-out` where `Empl_hand-out`.Emp_id=$IDEmpl"); 
                              while ($row1 = mysqli_fetch_array($result1, MYSQL_NUM))    
                  {    
                   $row1[0]=explode(" ", $row1[0])[0];          
                      $ID_item=$row1[1]; 
                  if  ($ID_item==1) { $sheet->setCellValueByColumnAndRow(3, $rowex, $row1[0]);}                  
                  elseif ($ID_item==2) { $sheet->setCellValueByColumnAndRow(5, $rowex, $row1[0]);}
                   elseif ($ID_item==3) { $sheet->setCellValueByColumnAndRow(7, $rowex, $row1[0]);}   
                    elseif ($ID_item==4) { $sheet->setCellValueByColumnAndRow(9, $rowex, $row1[0]);}   
                     elseif ($ID_item==5) { $sheet->setCellValueByColumnAndRow(11, $rowex, $row1[0]);}   
                      elseif ($ID_item==6) { $sheet->setCellValueByColumnAndRow(13, $rowex, $row1[0]);}   
                       elseif ($ID_item==7) { $sheet->setCellValueByColumnAndRow(15, $rowex, $row1[0]);}   
                        elseif ($ID_item==8) { $sheet->setCellValueByColumnAndRow(17, $rowex, $row1[0]);}   
              
                 }
              
$result2 = mysqli_query($link,"select quantity, id_item    from `Empl_hand-out` where `Empl_hand-out`.Emp_id=$IDEmpl"); 
                              while ($row2 = mysqli_fetch_array($result2, MYSQL_NUM))    
                  {      
                        $ID_item1=$row2[1]; 
                  if  ($ID_item1==1) { $sheet->setCellValueByColumnAndRow(4, $rowex, $row2[0]);}                  
                  elseif ($ID_item1==2) { $sheet->setCellValueByColumnAndRow(6, $rowex, $row2[0]);}
                   elseif ($ID_item1==3) { $sheet->setCellValueByColumnAndRow(8, $rowex, $row2[0]);}   
                    elseif ($ID_item1==4) { $sheet->setCellValueByColumnAndRow(10, $rowex, $row2[0]);}   
                     elseif ($ID_item1==5) { $sheet->setCellValueByColumnAndRow(12, $rowex, $row2[0]);}   
                      elseif ($ID_item1==6) { $sheet->setCellValueByColumnAndRow(14, $rowex, $row2[0]);}   
                       elseif ($ID_item1==7) { $sheet->setCellValueByColumnAndRow(16, $rowex, $row2[0]);}   
                        elseif ($ID_item1==8) { $sheet->setCellValueByColumnAndRow(18, $rowex, $row2[0]);}
               }     
               $sheet->getStyle("A$rowex:S$rowex")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("A$rowex")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("S$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("A$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("C$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("E$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("G$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("I$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("K$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("M$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("O$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("Q$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               
  $rowex++;        
            } 
  
$sheet->getStyle("A2:S2")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:S2")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:S2")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:S2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3:S3")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:S3")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:S3")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:S3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("C2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("B3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("C3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("D3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("E3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("F3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("G3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("I3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("J3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("K3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("L3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("M3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("N3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("O3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("P3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("Q3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("R3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
 

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
  