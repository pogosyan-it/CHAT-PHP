<?php
 session_start(); 
if(!isset($_SESSION['login'])){
     header("Location: \index.php");
     exit;                       }  
if(!isset($_SESSION['NORK_zakazy'])){
     header("Location: \Menu.php");
     exit;                    }  

   if(!preg_match('[\d] ', $_POST['date_from']))
   #or !preg_match('[\d] ', $_POST['date_by']))
  {
  $_SESSION['nodate'] = 'nodate';  
        header("Location: \NORK_zakazy.php");      
    exit;
  }
$date_from = $_POST['date_from'].' 00:00:00';
if (!preg_match('[\d] ', $_POST['date_by'])) 
   { 
      $date_by = date('Y-m-d H:i:s');
      
   }
else 
   {
      $date_by = $_POST['date_by'].' 23:59:59';
   }   
 # echo  $date_from, $date_by; 

  if ($date_from > $date_by)
  {
  $_SESSION['Nocorrectdate'] = $date_by;  
        header("Location: \NORK_zakazy.php");      
    exit;
  } 
  
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
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Подписываем лист
$sheet->setTitle('Отчет по реализации услуг');
$sheet->getDefaultStyle()->getFont()->setSize(10); 
$sheet->getPageMargins()->setTop(0);
$sheet->getPageMargins()->setRight(0.4);
$sheet->getPageMargins()->setLeft(0.5);
$sheet->getPageMargins()->setBottom(0);
$sheet->mergeCells('A1:O1');
$date = date('Y-m-d_H-i');
$sheet->setCellValue('A1', 'Интервал с '.$date_from.' по '.$date_by);
$sheet->setCellValue('A2', '№ накладной');
$sheet->setCellValue('B2', 'Дата');
$sheet->setCellValue('C2','Город отправления');
$sheet->setCellValue('D2','Страна отправления');
$sheet->setCellValue('E2','Заказчик');
$sheet->setCellValue('F2','Город получения');
$sheet->setCellValue('G2','Страна получения');
$sheet->setCellValue('H2','Сумма с НДС, руб');
$sheet->setCellValue('I2','Сумма в нац. валюте с НДС');                             //Пусто
$sheet->setCellValue('J2','Вес отправления, кг');
$sheet->setCellValue('K2','ДУ, СУ');
$sheet->setCellValue('L2','Форма оплаты');
$sheet->setCellValue('M2','Примечание');                                           //Пусто
$sheet->setCellValue('N2','Вид услуги');
$sheet->setCellValue('O2','Дата создания накладной (только по накладным ИМ)');    //Пусто

$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true); 
$sheet->getColumnDimension('G')->setAutoSize(true);  
#$sheet->getColumnDimension('H')->setAutoSize(true);
#$sheet->getColumnDimension('I')->setAutoSize(true);
#$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->getColumnDimension('K')->setAutoSize(true);
$sheet->getColumnDimension('L')->setAutoSize(true);
$sheet->getColumnDimension('M')->setAutoSize(true);
$sheet->getColumnDimension('N')->setAutoSize(true);
$sheet->getColumnDimension('O')->setWidth(18);

$sheet->getRowDimension(2)->setRowHeight(40);

$sheet->getStyle('A2:O2')->getAlignment()->setWrapText(true);

#$sheet->getColumnDimension('F')->setWidth(7);
$sheet->getStyle('A2:O2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:O2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:O2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:O2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

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
$sheet->getStyle('N2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('O2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$sheet->getStyle('A1:O1')->getFont()->setBold(true);
$sheet->getStyle('A2:O2')->getFont()->setBold(true);                    
$rowex=3;  
$S_Namenot="'ООО\"Даймэкс Корп\"', 'ООО \"Даймэкс-Корп\"', 'ООО Даймэкс-Корп', 'ДМ-КОРП', 'Даймэкс-Корп', 'Даймэкс Корп', 'ДМ КОРП', 'Даймэкс', 'ООО ДМ-КОРП', 'Даймэкс- КОРП'";
$S_Namenot=iconv("utf-8", "cp1251", $S_Namenot);

$result = mysqli_query($link,"select d15_departures.WayBillNum, d15_departures.WayBillDate, a.Name, hbc_country.Name,
                              d15_departures.S_Name, b.Name, d.Name, d15_departures.PaySumm,   
                              d15_departures.Sh_EWeight, d15_departures.Sh_Instructions, hbc_paymenttypes.Name,
                              d15_departures.Ser_type, d15_departures.Ser_ec, d15_departures.R_Addr, d15_departures.R_Contact,hbc_payers.Name 
                              from d15_departures
                              left join hbc_cities a on a.ID=d15_departures.S_CityID
                              left join hbc_cities b on b.ID=d15_departures.R_CityID
                              left join hbc_country  on hbc_country.ID=d15_departures.S_CountryID
                              left join hbc_country d on d.ID=d15_departures.R_CountryID
                              left join  hbc_paymenttypes on hbc_paymenttypes.ID=d15_departures.PayType
                              left join hbc_payers on hbc_payers.ID=d15_departures.Payment
                              where  d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 and d15_departures.WayBillNum is not null 
                              and d15_departures.S_Name not in ($S_Namenot)  and  d15_departures.R_Name not in  ($S_Namenot)
                              and d15_departures.S_CityID in (Select hbc_cities.ID from hbc_cities where hbc_cities.FedUnitID in ('21','29'))
                              and d15_departures.PickUpCode is NULL  and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by' and
                              d15_departures.WayBillNum not like '%!%'
                              or 
                              d15_departures.S_Name not in ($S_Namenot) and  d15_departures.R_Name not in ($S_Namenot) and
                              d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 
          										and d15_departures.WayBillNum is not null and d15_departures.PickUpCode is NULL and d15_departures.SY_Void=0 
          										and d15_departures.WarehousID=1 and d15_departures.S_Contact is NULL and d15_departures.WayBillNum not like '%!%' and
          										d15_departures.S_Addr is NULL and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by'
                              or
                              d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 and d15_departures.WayBillNum is not null 
                              and d15_departures.S_Name not in ($S_Namenot)  and  d15_departures.R_Name not in  ($S_Namenot)
                              and d15_departures.S_CityID in (Select hbc_cities.ID from hbc_cities where hbc_cities.FedUnitID in ('21','29'))
                              and d15_departures.PickUpCode not REGEXP '(1|59|91|956)-.*'  and d15_departures.WayBillNum not like '%!%'
                              and d15_departures.PickUpRTime >= '$date_from' and d15_departures.PickUpRTime <= '$date_by'
                              or
                              d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 and d15_departures.WayBillNum is not null 
                              and d15_departures.ToDivID not in ('1','2') and 
                              d15_departures.S_Name not in ('ООО\"Даймэкс Корп\"', 'ООО \"Даймэкс-Корп\"', 'ООО Даймэкс-Корп', 'ДМ-КОРП', 'Даймэкс-Корп', 'Даймэкс Корп', 'ДМ КОРП', 'Даймэкс', 'ООО ДМ-КОРП', 'Даймэкс- КОРП')  
                              and d15_departures.S_CityID in (Select hbc_cities.ID from hbc_cities where hbc_cities.FedUnitID in ('21','29'))
                              and d15_departures.PickUpCode is NULL  and d15_departures.WayBillNum not like '%!%'
                              and d15_departures.PickUpRTime >= '$date_from' and d15_departures.PickUpRTime <= '$date_by';"); 
                              
           while ($row = mysqli_fetch_array($result, MYSQL_NUM))    //13 
                  {       
                        $row[0]=iconv("cp1251", "utf-8", $row[0]);
                        $row[2]=iconv("cp1251", "utf-8", $row[2]);
                        $row[3]=iconv("cp1251", "utf-8", $row[3]);
                        $row[4]=iconv("cp1251", "utf-8", $row[4]);
                        $row[5]=iconv("cp1251", "utf-8", $row[5]);
                        $row[6]=iconv("cp1251", "utf-8", $row[6]);
                        $row[9]=iconv("cp1251", "utf-8", $row[9]);
                        $row[10]=iconv("cp1251", "utf-8", $row[10]);
                        $row[11]=iconv("cp1251", "utf-8", $row[11]);
                        $row[12]=iconv("cp1251", "utf-8", $row[12]);
                        $row[13]=iconv("cp1251", "utf-8", $row[13]);
                        $row[14]=iconv("cp1251", "utf-8", $row[14]); 
                        $row[15]=iconv("cp1251", "utf-8", $row[15]);                      
                       if ($row[12]=='4') {$Ser_ec='ДД';} 
                       elseif ($row[12]=='3') {$Ser_ec='СС';} 
                       elseif ($row[12]=='1') {$Ser_ec='ДС';} 
                       elseif ($row[12]=='2') {$Ser_ec='СД';}
                       else { $Ser_ec=''; }   
                     
                      if (preg_match_all("/^[Чч].{0,1}[Лл]$/u", $row[4]))  {$row[12]=$row[14];}
                      else                                                 {$row[12]=' ';}
                      if ($row[5]=='Заграница') {$row[5]=$row[5].' '.$row[13];}
                       $row[10]=$row[10].'  '.$row[15];
                       $sheet->setCellValueByColumnAndRow(0, $rowex, $row[0]);
                       $sheet->setCellValueByColumnAndRow(1, $rowex, $row[1]);
                       $sheet->setCellValueByColumnAndRow(2, $rowex, $row[2]);
                       $sheet->setCellValueByColumnAndRow(3, $rowex, $row[3]);
                       $sheet->setCellValueByColumnAndRow(4, $rowex, $row[4]);
                       $sheet->setCellValueByColumnAndRow(5, $rowex, $row[5]);
                       $sheet->setCellValueByColumnAndRow(6, $rowex, $row[6]);
                       $sheet->setCellValueByColumnAndRow(7, $rowex, $row[7]);
                       $sheet->setCellValueByColumnAndRow(9, $rowex, $row[8]);
                       $sheet->setCellValueByColumnAndRow(10, $rowex, $row[9]);
                       $sheet->setCellValueByColumnAndRow(11, $rowex, $row[10]);
                       $sheet->setCellValueByColumnAndRow(12, $rowex, $row[12]);
                       $sheet->setCellValueByColumnAndRow(13, $rowex, $Ser_ec);
                     
  $rowex++;                     
                  }              


$xls->createSheet();     
$xls->setActiveSheetIndex(1);
$sheet1 = $xls->getActiveSheet();
$sheet1->getPageSetup()
       ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet1->getPageSetup()
       ->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$sheet1->setTitle('Отчет по реализации Регионы');
$sheet1->getDefaultStyle()->getFont()->setSize(10); 
$sheet1->getPageMargins()->setTop(0);
$sheet1->getPageMargins()->setRight(0.4);
$sheet1->getPageMargins()->setLeft(0.5);
$sheet1->getPageMargins()->setBottom(0);
$sheet1->mergeCells('A1:O1');
$date = date('Y-m-d_H-i');
$sheet1->setCellValue('A1', 'Интервал с '.$date_from.' по '.$date_by);
$sheet1->setCellValue('A2', '№ накладной');
$sheet1->setCellValue('B2', 'Дата');
$sheet1->setCellValue('C2','Город отправления');
$sheet1->setCellValue('D2','Страна отправления');
$sheet1->setCellValue('E2','Заказчик');
$sheet1->setCellValue('F2','Город получения');
$sheet1->setCellValue('G2','Страна получения');
$sheet1->setCellValue('H2','Сумма с НДС, руб');
$sheet1->setCellValue('I2','Сумма в нац. валюте с НДС');                             //Пусто
$sheet1->setCellValue('J2','Вес отправления, кг');
$sheet1->setCellValue('K2','ДУ, СУ');
$sheet1->setCellValue('L2','Форма оплаты');
$sheet1->setCellValue('M2','Примечание');                                           //Пусто
$sheet1->setCellValue('N2','Вид услуги');
$sheet1->setCellValue('O2','Дата создания накладной (только по накладным ИМ)');    //Пусто

$sheet1->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$sheet1->getColumnDimension('A')->setAutoSize(true);
$sheet1->getColumnDimension('B')->setAutoSize(true);
$sheet1->getColumnDimension('C')->setAutoSize(true);
$sheet1->getColumnDimension('D')->setAutoSize(true);
$sheet1->getColumnDimension('E')->setAutoSize(true);
$sheet1->getColumnDimension('F')->setAutoSize(true); 
$sheet1->getColumnDimension('G')->setAutoSize(true);  
#$sheet1->getColumnDimension('H')->setAutoSize(true);
#$sheet1->getColumnDimension('I')->setAutoSize(true);
#$sheet1->getColumnDimension('J')->setAutoSize(true);
$sheet1->getColumnDimension('K')->setAutoSize(true);
$sheet1->getColumnDimension('L')->setAutoSize(true);
$sheet1->getColumnDimension('M')->setAutoSize(true);
$sheet1->getColumnDimension('N')->setAutoSize(true);
$sheet1->getColumnDimension('O')->setWidth(18);

$sheet1->getRowDimension(2)->setRowHeight(40);

$sheet1->getStyle('A2:O2')->getAlignment()->setWrapText(true);

#$sheet1->getColumnDimension('F')->setWidth(7);
$sheet1->getStyle('A2:O2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('A2:O2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('A2:O2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet1->getStyle('A2:O2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

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

$sheet1->getStyle('A1:O1')->getFont()->setBold(true);
$sheet1->getStyle('A2:O2')->getFont()->setBold(true);
$rowex1=3;  
$Zest="'Зест Экспресс', 'ЗестЭкспресс', 'Зест-Экспресс', 'Зест -Экспресс', 'Зест - Экспресс'";
$Rapid="'Сити Рапид', 'СитиРапид', 'Сити-Рапид', 'Сити -рапид', 'Сити - рапид'";
$Zest=iconv("utf-8", "cp1251", $Zest);
$Rapid=iconv("utf-8", "cp1251", $Rapid);       
$result1 = mysqli_query($link,"Select d15_departures.WayBillNum, d15_departures.WayBillDate, a.Name, hbc_country.Name,
                              d15_departures.S_Name, b.Name, d.Name, d15_departures.PaySumm,   
                              d15_departures.Sh_EWeight, d15_departures.Sh_Instructions, hbc_paymenttypes.Name,
                              d15_departures.Ser_type, d15_departures.Ser_ec, d15_departures.R_Addr, d15_departures.R_Contact,hbc_payers.Name 
                              from d15_departures
                              left join hbc_cities a on a.ID=d15_departures.S_CityID
                              left join hbc_cities b on b.ID=d15_departures.R_CityID
                              left join hbc_country  on hbc_country.ID=d15_departures.S_CountryID
                              left join hbc_country d on d.ID=d15_departures.R_CountryID
                              left join  hbc_paymenttypes on hbc_paymenttypes.ID=d15_departures.PayType
                              left join hbc_payers on hbc_payers.ID=d15_departures.Payment
                              where 
                              d15_departures.WarehousID=1 and  d15_departures.S_Name in ($Zest) and d15_departures.FromDivID<>1
                              and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by'
                              or 
                              d15_departures.WarehousID=1 and  d15_departures.S_Name in ($Rapid) and d15_departures.FromDivID<>1
                              and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by'
                              or
                              d15_departures.WarehousID=1 and d15_departures.R_Name in ($Zest) and d15_departures.FromDivID<>1
                              and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by'
                              or 
                              d15_departures.WarehousID=1 and d15_departures.R_Name in ($Rapid) and d15_departures.FromDivID<>1
                              and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by';"); 
                              
           while ($row1 = mysqli_fetch_array($result1, MYSQL_NUM))    //13 
                  {       
                        $row1[0]=iconv("cp1251", "utf-8", $row1[0]);
                        $row1[2]=iconv("cp1251", "utf-8", $row1[2]);
                        $row1[3]=iconv("cp1251", "utf-8", $row1[3]);
                        $row1[4]=iconv("cp1251", "utf-8", $row1[4]);
                        $row1[5]=iconv("cp1251", "utf-8", $row1[5]);
                        $row1[6]=iconv("cp1251", "utf-8", $row1[6]);
                        $row1[9]=iconv("cp1251", "utf-8", $row1[9]);
                        $row1[10]=iconv("cp1251", "utf-8", $row1[10]);
                        $row1[11]=iconv("cp1251", "utf-8", $row1[11]);
                        $row1[12]=iconv("cp1251", "utf-8", $row1[12]);
                        $row1[13]=iconv("cp1251", "utf-8", $row1[13]);
                        $row1[14]=iconv("cp1251", "utf-8", $row1[14]); 
                        $row1[15]=iconv("cp1251", "utf-8", $row1[15]);                      
                        if ($row1[12]=='4') {$Ser_ec1='ДД';} 
                       elseif ($row1[12]=='3') {$Ser_ec1='СС';} 
                       elseif ($row1[12]=='1') {$Ser_ec1='ДС';} 
                       elseif ($row1[12]=='2') {$Ser_ec1='СД';}
                       else { $Ser_ec1=''; }  
                     
                      if (preg_match_all("/^[Чч].{0,1}[Лл]$/u", $row1[4]))  {$row1[12]=$row1[14];}
                      else                                                 {$row1[12]=' ';}
                      if ($row1[5]=='Заграница') {$row1[5]=$row1[5].' '.$row1[13];}
                       $row1[10]=$row1[10].'  '.$row1[15];
                       $sheet1->setCellValueByColumnAndRow(0, $rowex1, $row1[0]);
                       $sheet1->setCellValueByColumnAndRow(1, $rowex1, $row1[1]);
                       $sheet1->setCellValueByColumnAndRow(2, $rowex1, $row1[2]);
                       $sheet1->setCellValueByColumnAndRow(3, $rowex1, $row1[3]);
                       $sheet1->setCellValueByColumnAndRow(4, $rowex1, $row1[4]);
                       $sheet1->setCellValueByColumnAndRow(5, $rowex1, $row1[5]);
                       $sheet1->setCellValueByColumnAndRow(6, $rowex1, $row1[6]);
                       $sheet1->setCellValueByColumnAndRow(7, $rowex1, $row1[7]);
                       $sheet1->setCellValueByColumnAndRow(9, $rowex1, $row1[8]);
                       $sheet1->setCellValueByColumnAndRow(10, $rowex1, $row1[9]);
                       $sheet1->setCellValueByColumnAndRow(11, $rowex1, $row1[10]);
                       $sheet1->setCellValueByColumnAndRow(12, $rowex1, $row1[12]);
                       $sheet1->setCellValueByColumnAndRow(13, $rowex1, $Ser_ec1);
                     
  $rowex1++;                     
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
  