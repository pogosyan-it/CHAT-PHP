<?php
 session_start(); 
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['mto'])){
     header("Location: \Menu.php");
     exit;     }
                      
     if(!isset($_SESSION['date'])){  
          $_SESSION['date'] = 'date';
     header("Location: \mto.php");
     exit;                    }
    
$date1=$_SESSION['date'];   
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
$sheet->setTitle('Выдача за день');
$sheet->getDefaultStyle()->getFont()->setSize(10);

$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0);
$sheet->getPageMargins()->setLeft(0);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:M1');
$sheet->mergeCells('A2:C2');
$sheet->mergeCells('D2:M2');
$date = date('Y-m-d_H-i');

$sheet->setCellValue('A1', 'Форменная одежда и инвентарь DIMEX');
$sheet->setCellValue('A2', 'Данные');
$sheet->setCellValue('D2', 'Выдано'.' '.$date1);
$sheet->setCellValue('A3', 'Ф.И.О.');
$sheet->setCellValue('B3', 'Рост');
$sheet->setCellValue('C3','Размер');
$sheet->setCellValue('D3','Куртка демисезонная');
$sheet->setCellValue('E3','Куртка зимняя');
$sheet->setCellValue('F3','Толстовка');
$sheet->setCellValue('G3','Поло');
$sheet->setCellValue('H3','Рюкзак');
$sheet->setCellValue('I3','Сумка');
$sheet->setCellValue('J3','Рулетка');
$sheet->setCellValue('K3','Весы безмен');
$sheet->setCellValue('L3','Подпись выдавшего');
$sheet->setCellValue('M3','Подпись принявшего');

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
$sheet->getColumnDimension('K')->setWidth(8);
$sheet->getColumnDimension('L')->setWidth(11);
$sheet->getColumnDimension('M')->setWidth(12);


$sheet->getStyle('A1:AC1')->getFont()->setBold(true);
$sheet->getStyle('A2:AC2')->getFont()->setBold(true);     
$sheet->getStyle('A3:AC3')->getFont()->setBold(true);               

$dateOT=$date1.' '.'00:00:00';  
$dateDO=$date1.' '.'23:59:59';

$rowex=4;  
$result = mysqli_query($link,"select distinct Employee.ID, Employee.SName, Size.height, Size.size
                              from `Empl_hand-out`
                              left join Employee on Employee.ID=`Empl_hand-out`.Emp_id
                              left join Size on Size.ID=`Empl_hand-out`.id_size
                              left join Item on Item.ID=`Empl_hand-out`.id_item
                              where `Empl_hand-out`.date > '$date1' and `Empl_hand-out`.date < '$dateDO' and Size.size is not null"); 
                              while ($row = mysqli_fetch_array($result, MYSQL_NUM))    
                  {      
                        $IDEmpl=$row[0];                   
                        $row[1]=iconv("cp1251", "utf-8", $row[1]);               
                       $sheet->setCellValueByColumnAndRow(0, $rowex, $row[1]);
                       $sheet->setCellValueByColumnAndRow(1, $rowex, $row[2]);  
                       $sheet->setCellValueByColumnAndRow(2, $rowex, $row[3]);
              
$result2 = mysqli_query($link,"select quantity, id_item    from `Empl_hand-out` where `Empl_hand-out`.Emp_id=$IDEmpl"); 
                              while ($row2 = mysqli_fetch_array($result2, MYSQL_NUM))    
                  {      
                        $ID_item1=$row2[1]; 
                  if  ($ID_item1==1) { $sheet->setCellValueByColumnAndRow(3, $rowex, $row2[0]);}                  
                  elseif ($ID_item1==2) { $sheet->setCellValueByColumnAndRow(4, $rowex, $row2[0]);}
                   elseif ($ID_item1==3) { $sheet->setCellValueByColumnAndRow(5, $rowex, $row2[0]);}   
                    elseif ($ID_item1==4) { $sheet->setCellValueByColumnAndRow(6, $rowex, $row2[0]);}   
                     elseif ($ID_item1==5) { $sheet->setCellValueByColumnAndRow(7, $rowex, $row2[0]);}   
                      elseif ($ID_item1==6) { $sheet->setCellValueByColumnAndRow(8, $rowex, $row2[0]);}   
                       elseif ($ID_item1==7) { $sheet->setCellValueByColumnAndRow(9, $rowex, $row2[0]);}   
                        elseif ($ID_item1==8) { $sheet->setCellValueByColumnAndRow(10, $rowex, $row2[0]);}
               }     
               $sheet->getStyle("A$rowex:M$rowex")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("A$rowex")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("M$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("A$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("C$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("D$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("E$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
               $sheet->getStyle("F$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("G$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("H$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("I$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("J$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("K$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("L$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getStyle("M$rowex")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
               $sheet->getRowDimension($rowex)->setRowHeight(25);
               $sheet->getStyle("A$rowex:AC$rowex")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
               $sheet->getStyle("A$rowex:AC$rowex")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
               
  $rowex++;        
            } 

   
 


$sheet->getStyle("A2:M2")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:M2")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:M2")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:M2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3:M3")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:M3")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:M3")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:M3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
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





unset($_SESSION['date']);

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
  