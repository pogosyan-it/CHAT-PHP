<?php
 session_start();
 if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['WaybillScan'])){
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
  if (empty($_POST["region"]))     // по умолчанию вес 0,5
        {  $_SESSION['noreg'] = 'noreg';  
        header("Location: \WaybillScan.php");      
    exit;
    }
   if (empty($_POST["sname"]))     // по умолчанию вес 0,5
        {  $_SESSION['noempl'] = 'noempl';  
        header("Location: \WaybillScan.php");      
    exit;
    }

$date=$_POST['date'];
#$day1=$day+1;   
$time_from=$date.' '.$_POST['hour'];
  
/*if ($_POST['hour'] =='16:00:00')  {
    $time_to=$year.'-'.$month.'-'.$day1.' '.'01:00:00';
}
else  {
$time_to=$year.'-'.$month.'-'.$day.' '.'16:00:00';
}       */


$sname=$_POST['sname'];
$dest=$_POST['region'];  
 
$res =  mysql_query("Select id from hb_employee where hb_employee.SName='$sname'");
  while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) 
                {
				     $id=$row['id'];   
                               }
                            $name=iconv("cp1251", "utf-8", $sname);
$res =  mysql_query("Select hbc_divisions.ID from hbc_divisions where hbc_divisions.Name='$dest'");
  while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) 
                {
				     $dest_id=$row['ID'];   
            
                }  
                   $id=@$id.'@';
                  $myresult=array(); 
                  $index=0;            
              if ($_POST['hour'] =='16:00:00')  {
    $time_to='01:00:00';
     $timeadd=$date.' '.'23:59:59';
    $result = mysql_query("SELECT syEvents.conID from syEvents where syEvents.LogText 
like '$id%' and syEvents.syAdding > '$time_from' and syEvents.syAdding < (SELECT DATE_ADD('$timeadd', INTERVAL 1 HOUR));");
    
                  while ($row = mysql_fetch_array($result, MYSQL_NUM)) 
                  {
                 
                   if ($row[0]!="")  {
                   $myresult[$index]=$row[0];
                   $index++; 
                  # $nocon=$row['conID'];
                 #  print($row[0])."</br>";                  	 
                                  }                                 
                  }
                    $str = implode("', '",$myresult); 
                    # echo $str."</br>";  
}
else  {
$time_to=$date.' '.'16:00:00';

$result = mysql_query("select syEvents.conID  from syEvents where syEvents.LogText
                            like '$id%' and syEvents.syAdding > '$time_from' and syEvents.syAdding < '$time_to'");
                  while ($row = mysql_fetch_array($result, MYSQL_NUM)) 
                  {
                 
                   if ($row[0]!="")  {
                   $myresult[$index]=$row[0];
                   $index++; 
                  # $nocon=$row['conID'];
                 #  print($row[0])."</br>";                  	 
                                  }                                 
                  }
                  $str = implode("', '",$myresult); 
}
 
#$Num=$index;
if ($index=='0') {
   $_SESSION['noconect'] = $sname;  
    $_SESSION['time_from'] = $time_from; 
    $_SESSION['time_to'] = $time_to; 
        header("Location: \WaybillScan.php"); 
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
$sheet->setTitle('Список накладных');
$sheet->getDefaultStyle()->getFont()->setSize(12); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:C1');
$date = date('d-m-Y H:i');
$sheet->setCellValue('A1','Сканировал: '.$name);
$sheet->setCellValue('A4','№');
$sheet->setCellValue('B4','Накладная');
$sheet->setCellValue('A2','Интервал сканирования: '.$time_from.' - '.$time_to); 
$sheet->setCellValue('A3','Регион отправителя: '.$dest);
$sheet->getColumnDimension('B')->setAutoSize(true); 
#$sheet->getStyleByColumnAndRow('1', 'A')->getFont()->setBold(true);
$sheet->getStyle('A4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:B4')->getFont()->setBold(true);
 
 $result = @mysql_query("select d15_departures.WayBillNum
                     from log_edit 
                     left join d15_departures on d15_departures.ID = log_edit.FieldID 
                     where log_edit.syConnUIN in ('$str') and log_edit.lValues like '%::WarehousID==%' and d15_departures.FromDivID='$dest_id'");
         $row = 5;
$col = 0;
while ($row_data = mysql_fetch_assoc($result))      {

foreach($row_data as $key=>$value) {
        $sheet->setCellValueByColumnAndRow(1, $row, $value);
        
        $col++;
                                   }
                                    
                                   $var=$col;
  
    $row++;
                                                  }
     
                  if (empty($value)) {
   $_SESSION['nodestination'] = $dest; 
   $_SESSION['user'] = $sname;  
        header("Location: \WaybillScan.php"); 
        exit;
} 
      for ($i = 5; $i < $var+5; $i++)     {
    
$sheet->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                          }
                                          
                                          for ($j = 5; $j < $var+5; $j++) {
    

$sheet->setCellValueByColumnAndRow(0, $j, $j-4);     
$sheet->getStyle('A'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$j)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);  
$sheet->getStyle('B'.$j)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$j)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$j)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('B'.$j)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);  

}

// Выводим HTTP-заголовки
 header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=$name.xls" );

// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 $objWriter->save('php://output'); 

// Echo memory usage    