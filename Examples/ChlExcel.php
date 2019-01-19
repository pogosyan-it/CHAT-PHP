<?php
 session_start();
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['Chl'])){
     header("Location: Menu.php");
     exit;                    }  

   if(!preg_match('[\d] ', $_POST['date_from']) or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \Chl.php");      
    exit;
  }
$date_from = $_POST['date_from'].' 00:00:00';
$date_by = $_POST['date_by'].' 23:59:59';
 # echo  $date_from, $date_by;

  if ($date_from > $date_by)
  {
  $_SESSION['Nocorrectdate'] = $date_by;  
        header("Location: \Chl.php");      
    exit;
  } 

function connect()
{ // BEGIN function connect
	mysql_connect("10.10.1.2", "root", "2me32jvppn");
  mysql_set_charset("CP1251");
  mysql_select_db("gsotldb");
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
$sheet->setTitle('ЧЛ');
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:K1');
$date = date('Y-m-d_H:i');
$sheet->setCellValue('A1', 'Интервал с '.$date_from.' по '.$date_by);
$sheet->setCellValue('A2','Номер накладной');
$sheet->setCellValue('B2','Маршрут');
$sheet->setCellValue('C2','Дата');
$sheet->setCellValue('D2','Город отправления');
$sheet->setCellValue('E2','Компания получателя');
$sheet->setCellValue('F2','Контактное лицо');
$sheet->setCellValue('G2','Фактический вес');
$sheet->setCellValue('H2','Объемный вес');
$sheet->setCellValue('I2','Город получателя');
$sheet->setCellValue('J2','Спец. инструкции');
$sheet->setCellValue('K2','Курьер');
$sheet->setCellValue('L2','Время доставки');
$sheet->setCellValue('M2','ФИО получателя');
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
$sheet->getColumnDimension('K')->setAutoSize(true); 
$sheet->getColumnDimension('L')->setAutoSize(true);
$sheet->getColumnDimension('M')->setAutoSize(true); 
 
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);

$sheet->getStyle('A2:M2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:M2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:M2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:M2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('K2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('M2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$sheet->getStyle('A1:M1')->getFont()->setBold(true);
$sheet->getStyle('A2:M2')->getFont()->setBold(true);                    
  $row1=3;  
    $chl='ч%л';
    $neotp='не отп';
    $otp='отп';
    $chl=iconv("utf-8", "cp1251", $chl);
    $neotp=iconv("utf-8", "cp1251", $neotp);
    $otp=iconv("utf-8", "cp1251", $otp);
      $result = mysql_query("Select d15_departures.WayBillNum, hbc_routes.Name,
                        d15_departures.SY_Adding, a.Mask as Amask,
                        d15_departures.R_Name, d15_departures.R_Contact, d15_departures.Sh_Weight as Weight, 
                        d15_departures.Sh_VWeight as VWeight, b.Mask as Bmask, 
                        d15_departures.Sh_discr, hb_employee.SName, d20_extask.cpName, d20_extask.ExTimeStamp

                        from d20_extask

                        left join d21_extasklist on d20_extask.d21ID=d21_extasklist.ID
                        left join d15_departures on d15_departures.ID=d20_extask.dXXID
                        left join hb_employee on hb_employee.ID=d21_extasklist.employeeID
                        left join hbc_divisions a on a.ID=d15_departures.FromDivID
                        left join hbc_divisions b on b.ID=d15_departures.ToDivID
                        left join hbc_routes  on hbc_routes.ID=d15_departures.R_RouteID

                        WHERE d20_extask.stateKey='7' and d20_extask.cpName not in ('NULL','')
                        and d15_departures.WayBillNum is not NULL and d20_extask.cpName not in ('$neotp','$otp') and d15_departures.R_Name like '$chl'
                        and d15_departures.SY_Adding > '$date_from' and d15_departures.SY_Adding < '$date_by';");  
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
       
         $WayBillNum=$row['WayBillNum'];
         $Name=$row['Name'];
         $SY_Adding=$row['SY_Adding'];
         $Amask=$row['Amask'];
         $R_Name=$row['R_Name'];
         $R_Contact=$row['R_Contact'];
         $weight=$row['Weight'];
         $vweight=$row['VWeight'];
         $Bmask=$row['Bmask'];
         $Sh_discr=$row['Sh_discr'];
         $SName=$row['SName'];
         $cpName=$row['cpName'];
         $ExTimeStamp=$row['ExTimeStamp']; 
         
         $Amask=iconv("cp1251", "utf-8", $Amask); 
         $R_Name=iconv("cp1251", "utf-8", $R_Name); 
         $R_Contact=iconv("cp1251", "utf-8", $R_Contact); 
         $Bmask=iconv("cp1251", "utf-8", $Bmask); 
         $Sh_discr=iconv("cp1251", "utf-8", $Sh_discr); 
         $SName=iconv("cp1251", "utf-8", $SName); 
         $ExTimeStamp=iconv("cp1251", "utf-8", $ExTimeStamp);
         $cpName=iconv("cp1251", "utf-8", $cpName); 
                                       
    $sheet->setCellValueByColumnAndRow(0, $row1, $WayBillNum);
    $sheet->setCellValueByColumnAndRow(1, $row1, $Name);
    $sheet->setCellValueByColumnAndRow(2, $row1, $SY_Adding);  
    $sheet->setCellValueByColumnAndRow(3, $row1, $Amask);
    $sheet->setCellValueByColumnAndRow(4, $row1, $R_Name);
    $sheet->setCellValueByColumnAndRow(5, $row1, $R_Contact); 
    $sheet->setCellValueByColumnAndRow(6, $row1, $weight);                                      
    $sheet->setCellValueByColumnAndRow(7, $row1, $vweight);
    $sheet->setCellValueByColumnAndRow(8, $row1, $Bmask);                                      
    $sheet->setCellValueByColumnAndRow(9, $row1, $Sh_discr);
    $sheet->setCellValueByColumnAndRow(10, $row1, $SName);
    $sheet->setCellValueByColumnAndRow(11, $row1, $ExTimeStamp);
    $sheet->setCellValueByColumnAndRow(12, $row1, $cpName);
                                       
                               $row1++;         
                                                           }                  
   
  /* for ($i = 2; $i < $row1; $i++)     {
$sheet->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                                                                    }                   */
    
  
     
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
  