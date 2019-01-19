<?php
 session_start(); 
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['IncorrectClients'])){
     header("Location: \Menu.php");
     exit;                    }  

   if(!preg_match('[\d] ', $_POST['date']))
   #or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \IncorrectClients.php");      
    exit;
  }
$date = $_POST['date'];
$date1 = $date.' 00:00:00';

  
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
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
#$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Подписываем лист
$sheet->setTitle('Некорректные организации');
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:E1');
$date = date('Y-m-d_H-i');
$sheet->setCellValue('A1', 'Дата с '.$date1);
$sheet->setCellValue('A2', 'Город');
$sheet->setCellValue('B2', 'Название Организации');
$sheet->setCellValue('C2', 'Улица');
$sheet->setCellValue('D2','Адрес');
$sheet->setCellValue('E2','Создал');

$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
 
#$sheet->getColumnDimension('H')->setAutoSize(true);
#$sheet->getColumnDimension('I')->setAutoSize(true);
#$sheet->getColumnDimension('J')->setAutoSize(true);


#$sheet->getRowDimension(2)->setRowHeight(40);

$sheet->getStyle('A2:E2')->getAlignment()->setWrapText(true);

#$sheet->getColumnDimension('F')->setWidth(7);
 

$sheet->getStyle('A1:E1')->getFont()->setBold(true);
$sheet->getStyle('A2:E2')->getFont()->setBold(true);                    
$rowex=3;  

$result = mysqli_query($link,"Select distinct hbc_cities.Name, d80_clients.FullName, concat (d81_client2addr.Strit, ' ', d81_client2addr.StritPref) as `street`, d81_client2addr.AddrStr, hb_employee.SName
                              from d86_clapc
                              left join d80_clients  on d80_clients.ID=d86_clapc.d80ID
                              left join d81_client2addr  on d81_client2addr.ID=d86_clapc.d81ID
                              left join hbc_cities on hbc_cities.ID=d81_client2addr.CityID
                              left join hb_employee on hb_employee.ID=d81_client2addr.SY_Empl
                              where 
                              d81_client2addr.Strit <> SUBSTRING_INDEX(d81_client2addr.AddrStr, lower (d81_client2addr.StritPref), 1)
                              and d81_client2addr.SY_Adding > '$date1' and d80_clients.ExDiv not in (254);"); 
                              
           while ($row = mysqli_fetch_array($result, MYSQL_NUM))    
                  {       
                        $row[0]=iconv("cp1251", "utf-8", $row[0]);
                        $row[1]=iconv("cp1251", "utf-8", $row[1]);
                        $row[2]=iconv("cp1251", "utf-8", $row[2]);
                        $row[3]=iconv("cp1251", "utf-8", $row[3]);
                        $row[4]=iconv("cp1251", "utf-8", $row[4]);
                        
                       $sheet->setCellValueByColumnAndRow(0, $rowex, $row[0]);
                       $sheet->setCellValueByColumnAndRow(1, $rowex, $row[1]);
                       $sheet->setCellValueByColumnAndRow(2, $rowex, $row[2]);
                       $sheet->setCellValueByColumnAndRow(3, $rowex, $row[3]);
                       $sheet->setCellValueByColumnAndRow(4, $rowex, $row[4]);
  $rowex++;                     
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
  