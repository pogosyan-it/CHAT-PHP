<?php
 session_start(); 
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['mto'])){
     header("Location: \Menu.php");
     exit;                    } 
     if(!isset($_SESSION['SName'])){
          $_SESSION['noname'] = 'noname';
     header("Location: \mto.php");
     exit;                    }
        
  
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
$sheet->setTitle('Приём у чувака');
$sheet->getDefaultStyle()->getFont()->setSize(11);
$sheet->getStyle("A4:L4")->getFont()->setSize(10);  
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0);
$sheet->getPageMargins()->setLeft(0);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A2:D2');
$date = date('Y-m-d_H-i');
$sheet->setCellValue('A1', 'Форменная одежда и инвентарь DIMEX');
$sheet->setCellValue('A2', 'Данные');
$sheet->setCellValue('E2', 'Принято');
$sheet->setCellValue('A3', 'Ф.И.О.');
$sheet->setCellValue('B3', 'Рост');
$sheet->setCellValue('C3','Размер');
$sheet->setCellValue('D3','Дата');

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
$sheet->getRowDimension(4)->setRowHeight(33);

$sheet->getStyle('A3:AC3')->getAlignment()->setWrapText(true);
$sheet->getStyle('A2:L2')->getAlignment()->setWrapText(true);
$sheet->getColumnDimension('A')->setWidth(24);
$sheet->getColumnDimension('B')->setWidth(7);
$sheet->getColumnDimension('C')->setWidth(8);
$sheet->getColumnDimension('D')->setWidth(9);
$sheet->getColumnDimension('E')->setWidth(12);
$sheet->getColumnDimension('F')->setWidth(12);
$sheet->getColumnDimension('G')->setWidth(12);
$sheet->getColumnDimension('H')->setWidth(12);
$sheet->getColumnDimension('I')->setWidth(12);
$sheet->getColumnDimension('J')->setWidth(12);
$sheet->getColumnDimension('K')->setWidth(12);
$sheet->getColumnDimension('L')->setWidth(12);

$sheet->getStyle('A1:AC1')->getFont()->setBold(true);
$sheet->getStyle('A2:AC2')->getFont()->setBold(true);     
$sheet->getStyle('A3:AC3')->getFont()->setBold(true);               

  $date=$_SESSION['date'];    
  $SName=$_SESSION['SName']; 
  @$size=$_SESSION['size'];
  @$height=$_SESSION['height'];
  unset($_SESSION['SName']); 
  unset($_SESSION['size']);
  unset($_SESSION['height']);
  unset($_SESSION['date']);
  @$Item_id_1=$_SESSION['Item_id_1'];
  @$Item_id_2=$_SESSION['Item_id_2'];
  @$Item_id_3=$_SESSION['Item_id_3'];
  @$quantity_1=$_SESSION['quantity_1'];
  @$quantity_2=$_SESSION['quantity_2'];
  @$quantity_3=$_SESSION['quantity_3'];
  @$prociznosa1=$_SESSION['prociznosa1'];
  @$prociznosa2=$_SESSION['prociznosa2'];
  @$prociznosa3=$_SESSION['prociznosa3'];
  $Item_id_1=iconv("cp1251", "utf-8", $Item_id_1);
  $Item_id_2=iconv("cp1251", "utf-8", $Item_id_2);
  $Item_id_3=iconv("cp1251", "utf-8", $Item_id_3);
  $SName=iconv("cp1251", "utf-8", $SName);
  $procname='% износа';
@$sheet->setCellValueByColumnAndRow(0, 4, $SName);
@$sheet->setCellValueByColumnAndRow(1, 4, $height);
@$sheet->setCellValueByColumnAndRow(2, 4, $size);
@$sheet->setCellValueByColumnAndRow(3, 4, $date);
@$sheet->setCellValueByColumnAndRow(4, 3, $Item_id_1);
@$sheet->setCellValueByColumnAndRow(4, 4, $_SESSION['quantity_1']);
@$sheet->setCellValueByColumnAndRow(5, 4, $_SESSION['prociznosa1']);
@$sheet->setCellValueByColumnAndRow(6, 3, $Item_id_2);
@$sheet->setCellValueByColumnAndRow(6, 4, $_SESSION['quantity_2']);
@$sheet->setCellValueByColumnAndRow(7, 4, $_SESSION['prociznosa2']);
@$sheet->setCellValueByColumnAndRow(8, 3, $Item_id_3);
@$sheet->setCellValueByColumnAndRow(8, 4, $_SESSION['quantity_3']);
@$sheet->setCellValueByColumnAndRow(9, 4, $_SESSION['prociznosa3']);
  
@$sheet->setCellValueByColumnAndRow(5, 3, $procname);
$stolb=6;  
if  (isset ($_SESSION['Item_id_2'])) {@$sheet->setCellValueByColumnAndRow(7, 3, $procname); $stolb=8;}
if  (isset ($_SESSION['Item_id_3'])) {@$sheet->setCellValueByColumnAndRow(9, 3, $procname); $stolb=10;}

$sheet->getStyle("D2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

if ($stolb==6) {
$sheet->mergeCells("A1:H1");
$sheet->getStyle("A2:H2")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:H2")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:H2")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:H2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3:H3")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:H3")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:H3")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:H3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A4:H4")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:H4")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:H4")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:H4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("B3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("C3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("D3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("E3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("F3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("G3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("G2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("F2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("B4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("C4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("D4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("E4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("F4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("G4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->mergeCells("A1:H1");
$sheet->mergeCells("E2:F2");
$sheet->mergeCells("G2:G3"); 
$sheet->mergeCells("H2:H3"); 
@$sheet->setCellValueByColumnAndRow(6, 2, 'подпись сдавшего');
@$sheet->setCellValueByColumnAndRow(7, 2, 'подпись принявшего');
}

if ($stolb==8) {$bukva='H2'; 
$sheet->mergeCells("A1:L1");
$sheet->getStyle("A2:J2")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:J2")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:J2")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:J2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3:J3")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:J3")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:J3")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:J3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A4:J4")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:J4")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:J4")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:J4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("B3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("C3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("D3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("E3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("F3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("G3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("I3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("I2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("B4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("C4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("D4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("E4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("F4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("G4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("I4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("J4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->mergeCells("A1:J1");
$sheet->mergeCells("E2:H2");
$sheet->mergeCells("I2:I3"); 
$sheet->mergeCells("J2:J3"); 
@$sheet->setCellValueByColumnAndRow(8, 2, 'подпись сдавшего');
@$sheet->setCellValueByColumnAndRow(9, 2, 'подпись принявшего');
}
if ($stolb==10) {$bukva='J2'; 
$sheet->mergeCells("A1:L1");
$sheet->getStyle("A2:L2")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:L2")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:L2")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A2:L2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3:L3")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:L3")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:L3")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A3:L3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A4:L4")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:L4")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:L4")->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4:L4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);   
$sheet->getStyle("A3")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
$sheet->getStyle("J2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("A4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("B4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("C4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("D4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("E4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("F4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("G4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("H4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("I4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("J4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("K4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("L4")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle("K2")->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->mergeCells("A1:L1");
$sheet->mergeCells("E2:J2");
$sheet->mergeCells("K2:K3"); 
$sheet->mergeCells("L2:L3"); 
@$sheet->setCellValueByColumnAndRow(10, 2, 'подпись сдавшего');
@$sheet->setCellValueByColumnAndRow(11, 2, 'подпись принявшего');
}

unset($_SESSION['Item_id_1']);
unset($_SESSION['quantity_1']);
unset($_SESSION['prociznosa1']);
unset($_SESSION['Item_id_2']);
unset($_SESSION['quantity_2']);
unset($_SESSION['prociznosa2']);
unset($_SESSION['Item_id_3']);
unset($_SESSION['quantity_3']);
unset($_SESSION['prociznosa3']);
unset($_SESSION['date']);
unset($_SESSION['SName']);

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
  