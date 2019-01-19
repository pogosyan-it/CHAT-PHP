<?php
 session_start();
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['ScanMan'])){
     header("Location: Menu.php");
     exit;                    } 

function connect()
{ // BEGIN function connect
	mysql_connect("10.10.1.2", "root", "2me32jvppn");
  mysql_set_charset("cp1251");
  mysql_select_db("gsotldb");
  mysql_query("SET NAMES 'cp1251'");
} // END function connect  
   
  connect();    
  if (empty($_POST["ManifestNum"]))     
        {  $_SESSION['nomanifest'] = 'nomanifest';  
        header("Location: \ScanMan.php");      
    exit;
    }
  
$manifest=$_POST['ManifestNum'];

   $myresult=array();  
    $index=0;       
  $result =  mysql_query("select d15_departures.WayBillNum FROM d31_manifest2departure
                               left join d56vo2departure on d31_manifest2departure.d15ID=d56vo2departure.d15ID
                               left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                               left join hb_employee on d56vo2departure.SY_Empl=hb_employee.ID
                               left join d15_departures on d31_manifest2departure.d15ID=d15_departures.ID
                                WHERE d30_manifests.ManifestNum='$manifest' order by d56vo2departure.SY_LastEdit ASC;");  
                     while ($row = mysql_fetch_array($result, MYSQL_NUM)) 
                 {
                   if ($row[0]!="")  {
                   $myresult[$index]=$row[0];
                   $index++; 
                		   
                                  }
                                
                  }
                                  
             $num=$index;
             if (empty($num))     
        {  $_SESSION['nowaybill'] = 'nowaybill';  
        header("Location: \ScanMan.php");      
    exit;
    }
              
           
     
      
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

// Подписываем лист
$sheet->setTitle($manifest);
$sheet->getDefaultStyle()->getFont()->setSize(12); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:C1');
$date = date('d-m-Y H:i');
$sheet->setCellValue('A1','№ манифеста: '.$manifest);
$sheet->setCellValue('A2','№');
$sheet->setCellValue('B2','Накладная');
$sheet->setCellValue('C2','Дата сканирования');
$sheet->setCellValue('D2','ФИО');
$sheet->setCellValue('E2','IP');
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);  
$sheet->getColumnDimension('E')->setAutoSize(true);  
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);
$sheet->getStyle('A2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A1:E2')->getFont()->setBold(true);
 $row1 = 3;
 for ($d = 0; $d <= $num-1; $d++)  
 {
 $myres=array();  
  $j=0;       
  $res =  @mysql_query("SELECT d56vo2departure.SY_LastEdit FROM d56vo2departure
                                     left join hb_employee on d56vo2departure.SY_Empl=hb_employee.ID 
                                     left join d15_departures on d56vo2departure.d15ID=d15_departures.ID
                                     WHERE d15_departures.WayBillNum='$myresult[$d]' AND d15_departures.SY_Void = 0 
                                     AND d15_departures.WarehousID > 0 ORDER BY d56vo2departure.SY_Adding ASC Limit 1");  
                     while ($row = mysql_fetch_array($res, MYSQL_NUM)) 
                 {
                   if ($row[0]!="")  {
                   $myres[$j]=$row[0];
                   $j++; 
                			   
                                  }
                                           
                  }
            if ($j==0) {
                       $sheet->setCellValueByColumnAndRow(1, $row1, $myresult[$d]);
    $sheet->setCellValueByColumnAndRow(2, $row1, 'не сканировалась');
                     #    echo "Накладная $myresult[$d] не сканировалась";
                      #   echo  "</br>"; 
                       }
            else  {                      
                              
 $result = mysql_query("SELECT d56vo2departure.SY_LastEdit, d56vo2departure.SY_Empl, hb_employee.SName
                                FROM d56vo2departure
                                left join hb_employee on d56vo2departure.SY_Empl=hb_employee.ID 
                                left join d15_departures on d56vo2departure.d15ID=d15_departures.ID
                                WHERE d15_departures.WayBillNum='$myresult[$d]' AND d15_departures.SY_Void = 0 
                                AND d15_departures.WarehousID > 0 ORDER BY d56vo2departure.SY_Adding ASC Limit 1 INTO @t1, @EmplID, @SName;");

    $result = mysql_query("SELECT CONCAT (@EmplID, '@%') INTO @Empl;"); 
    $result = mysql_query("SELECT syEvents.conID from syEvents
                                   where syEvents.LogText like @Empl and syEvents.syAdding < @t1 order by syEvents.syAdding DESC Limit 1 INTO @conID;");   
    $result = mysql_query("SELECT @t1 as Time, @SName as Sname, syEvents.LogText as IP from syEvents
                                    where syEvents.UIN = @conID;");  
     while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
         $time=$row['Time'];
         $name=$row['Sname'];
         $IP=$row['IP'];
         @$ipScan = substr($IP,5);
         $Sname=iconv("cp1251", "utf-8", $name); 
         
    }
 #  echo "$myresult[$d], $time, $name, $IP";
                  #       echo  "</br>";                               
    $sheet->setCellValueByColumnAndRow(1, $row1, $myresult[$d]);
    $sheet->setCellValueByColumnAndRow(2, $row1, $time);
    $sheet->setCellValueByColumnAndRow(3, $row1, $Sname);
    $sheet->setCellValueByColumnAndRow(4, $row1, $ipScan);                                        
                                    }
  $row1++;   } 
  
   for ($i = 3; $i < $row1; $i++)     {

$sheet->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);    
$sheet->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('D'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('E'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                                                                    }
                                                                                    
        for ($j = 3; $j < $row1; $j++)  {
    
$sheet->setCellValueByColumnAndRow(0, $j, $j-2);     
}  
     
// Выводим HTTP-заголовки
 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=$manifest.xls" );

// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 $objWriter->save('php://output'); 

// Echo memory usage        
  