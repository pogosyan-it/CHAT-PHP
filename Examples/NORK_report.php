<?php

# Зест
 
$date_from = date('Y-m-d H:i:s', strtotime( ' -7 day'));
#$date_by = date('Y-m-d H:i:s', strtotime( ' -11 day'));
$date_by = date('Y-m-d H:i:s');

  
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
$sheet->mergeCells('A1:Q1');
$date = date('Y-m-d_H-i');
$sheet->setCellValue('A1', 'НОРК интервал с '.$date_from.' по '.$date_by);
$sheet->setCellValue('A2', '№ накладной');
$sheet->setCellValue('B2', 'Дата');
$sheet->setCellValue('C2','Регион отправления');
$sheet->setCellValue('D2','Регион назначения');
$sheet->setCellValue('E2','Отправитель');
$sheet->setCellValue('F2','Получатель');
$sheet->setCellValue('G2','Город доставки');
$sheet->setCellValue('H2','Содержимое');
$sheet->setCellValue('I2','Вес Э');                             //Пусто
$sheet->setCellValue('J2','Вес Ф');
$sheet->setCellValue('K2','Количество мест');
$sheet->setCellValue('L2','Дата и Время приемки груза');
$sheet->setCellValue('M2','Вид услуги');                                           //Пусто
$sheet->setCellValue('N2','Способ отправки');
$sheet->setCellValue('O2','Номер рейса'); 
$sheet->setCellValue('P2','Т/н'); 
$sheet->setCellValue('Q2','дата и время сдачи груза перевозчику');                                          //Пусто



   //Пусто

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
$sheet->getColumnDimension('N')->setAutoSize(true);
$sheet->getColumnDimension('O')->setAutoSize(true);
$sheet->getColumnDimension('P')->setAutoSize(true);
$sheet->getColumnDimension('Q')->setWidth(18);

$sheet->getRowDimension(2)->setRowHeight(40);

$sheet->getStyle('A2:Q2')->getAlignment()->setWrapText(true);

#$sheet->getColumnDimension('F')->setWidth(7);
$sheet->getStyle('A2:Q2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:Q2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:Q2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A2:Q2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

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
$sheet->getStyle('P2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('P2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$sheet->getStyle('A1:Q1')->getFont()->setBold(true);
$sheet->getStyle('A2:Q2')->getFont()->setBold(true);                    
                                                         
$index=3;
$S_Namenot="'ООО\"Даймэкс Корп\"', 'ООО \"Даймэкс-Корп\"', 'ООО Даймэкс-Корп', 'ДМ-КОРП', 'Даймэкс-Корп', 'Даймэкс Корп', 'ДМ КОРП', 'Даймэкс', 'ООО ДМ-КОРП', 'Даймэкс- КОРП'";
$S_Namenot=iconv("utf-8", "cp1251", $S_Namenot);
      
                      $ekon=iconv("utf-8", "cp1251", 'Эконом');
                      $express=iconv("utf-8", "cp1251", 'Экспресс');
                      $res=mysqli_query($link, "TRUNCATE nork_tmp;");
                      $res=mysqli_query($link, "insert into nork_tmp (d15ID, WayBillNum) 
                                                select d15_departures.ID,d15_departures.WayBillNum  
                                                  from d15_departures
                                                  left join hbc_cities a on a.ID=d15_departures.S_CityID
                                                  left join hbc_cities b on b.ID=d15_departures.R_CityID
                                                  left join hbc_country  on hbc_country.ID=d15_departures.S_CountryID
                                                  left join hbc_country d on d.ID=d15_departures.R_CountryID
                                                  left join  hbc_paymenttypes on hbc_paymenttypes.ID=d15_departures.PayType
                                                  where  d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 and d15_departures.WayBillNum is not null 
                                                  and d15_departures.S_Name not in ($S_Namenot)  and  d15_departures.R_Name not in  ($S_Namenot)  and d15_departures.WayBillNum not like '%!%'  
                                                  and d15_departures.S_CityID in (Select hbc_cities.ID from hbc_cities where hbc_cities.FedUnitID in ('21','29')) and d15_departures.SY_Void=0
                                                  and d15_departures.PickUpCode is NULL  and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by'
                                                  or 
                                                  d15_departures.S_Name not in ($S_Namenot) and  d15_departures.R_Name not in ($S_Namenot) and
                                                  d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 
                              										and d15_departures.WayBillNum is not null and d15_departures.PickUpCode is NULL and d15_departures.SY_Void=0 
                              										and d15_departures.WarehousID=1 and d15_departures.S_Contact is NULL and d15_departures.WayBillNum not like '%!%'   and 
                              										d15_departures.S_Addr is NULL and d15_departures.WayBillDate >= '$date_from' and d15_departures.WayBillDate <= '$date_by'
                                                  or
                                                  d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 and d15_departures.WayBillNum is not null 
                                                  and d15_departures.S_Name not in ($S_Namenot)  and  d15_departures.R_Name not in  ($S_Namenot)  and d15_departures.SY_Void=0
                                                  and d15_departures.S_CityID in (Select hbc_cities.ID from hbc_cities where hbc_cities.FedUnitID in ('21','29'))
                                                  and d15_departures.PickUpCode not REGEXP '(1|59|91|956)-.*' and d15_departures.WayBillNum not like '%!%'   
                                                  and d15_departures.PickUpRTime >= '$date_from' and d15_departures.PickUpRTime <= '$date_by'
                                                  or
                                                  d15_departures.SY_OwnDiv=1 and d15_departures.fSidePost=0 and d15_departures.FromDivID=1 and d15_departures.WayBillNum is not null 
                                                  and d15_departures.ToDivID not in ('1','2') and d15_departures.SY_Void=0 and 
                                                  d15_departures.S_Name not in ('ООО\"Даймэкс Корп\"', 'ООО \"Даймэкс-Корп\"', 'ООО Даймэкс-Корп', 'ДМ-КОРП', 'Даймэкс-Корп', 'Даймэкс Корп', 'ДМ КОРП', 'Даймэкс', 'ООО ДМ-КОРП', 'Даймэкс- КОРП')  
                                                  and d15_departures.S_CityID in (Select hbc_cities.ID from hbc_cities where hbc_cities.FedUnitID in ('21','29'))
                                                  and d15_departures.PickUpCode is NULL  and d15_departures.WayBillNum not like '%!%'
                                                  and d15_departures.PickUpRTime >= '$date_from' and d15_departures.PickUpRTime <= '$date_by';");
                                                  
                      $res = mysqli_query($link,"select d15_departures.WayBillNum, d15_departures.WayBillDate, a.Name, b.Name, 
                                                  d15_departures.S_Name, d15_departures.R_Name, d.Name, d15_departures.Sh_discr, 
                                                  d15_departures.Sh_EWeight, d15_departures.Sh_Weight, d15_departures.Sh_Place,  
                                                  IF(d15_departures.Ser_type ='1' , '$ekon', '$express'), hbc_transporttypes.Name, d50_vo.RNumber, d50_vo.WayBill,
                                                  d50_vo.lCargoSent, d15_departures.R_Contact, d15_departures.R_Addr, d15_departures.S_Contact
                                                  from d15_departures
                                                  left join hbc_divisions a on a.ID=d15_departures.FromDivID
                                                  left join hbc_divisions b on b.ID=d15_departures.ToDivID
                                                  left join hbc_cities c on c.ID=d15_departures.S_CityID
                                                  left join hbc_cities d on d.ID=d15_departures.R_CityID
                                                  left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                                                  left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                                                  left join d56vo2departure on d56vo2departure.d15ID=d15_departures.ID
                                                  left join d50_vo on d50_vo.ID=d30_manifests.d50ID
                                                  join nork_tmp on d15_departures.ID=nork_tmp.d15ID
                                                  left join hbc_transporttypes on hbc_transporttypes.ID=d50_vo.SendType
                                                  where d15_departures.ID in (Select d15ID from nork_tmp) 
                                                  and d30_manifests.SY_Void=0 and d31_manifest2departure.SY_Void=0 and d15_departures.ToDivID<>1 and d30_manifests.ToDiv not in ('116')
                                                  or d15_departures.ID in (Select d15ID from nork_tmp) and d15_departures.ToDivID=1;");
             
             while ($row1 = mysqli_fetch_array($res, MYSQL_NUM))    //16 полей 
                  {     
                        $row1[0]=iconv("cp1251", "utf-8", $row1[0]);  
                        
                        $row1[4]=iconv("cp1251", "utf-8", $row1[4]);
                        $row1[5]=iconv("cp1251", "utf-8", $row1[5]);
                        $row1[6]=iconv("cp1251", "utf-8", $row1[6]);
                        $row1[7]=iconv("cp1251", "utf-8", $row1[7]);
                        $row1[11]=iconv("cp1251", "utf-8", $row1[11]);
                        $row1[12]=iconv("cp1251", "utf-8", $row1[12]);
                        $row1[13]=iconv("cp1251", "utf-8", $row1[13]);
                        $row1[14]=iconv("cp1251", "utf-8", $row1[14]);                   
                        $row1[15]=iconv("cp1251", "utf-8", $row1[15]);
                        $row1[16]=iconv("cp1251", "utf-8", $row1[16]);
                        $row1[17]=iconv("cp1251", "utf-8", $row1[17]); 
                        $row1[18]=iconv("cp1251", "utf-8", $row1[18]);
  
  if (preg_match_all("/^[Чч].{0,1}[Лл]$/u", $row1[4])) {$row1[4]=$row1[4].' '.$row1[18];}
  if (preg_match_all("/^[Чч].{0,1}[Лл]$/u", $row1[5]))  {$row1[5]=$row1[5].' '.$row1[16];}
  if ($row1[6]=='Заграница') {$row1[6]=$row1[6].' '.$row1[17];}

                               
                       $sheet->setCellValueByColumnAndRow(0, $index, $row1[0]);
                       $sheet->setCellValueByColumnAndRow(1, $index, $row1[1]);
                       $sheet->setCellValueByColumnAndRow(2, $index, $row1[2]);
                       $sheet->setCellValueByColumnAndRow(3, $index, $row1[3]);
                       $sheet->setCellValueByColumnAndRow(4, $index, $row1[4]);
                       $sheet->setCellValueByColumnAndRow(5, $index, $row1[5]);
                       $sheet->setCellValueByColumnAndRow(6, $index, $row1[6]);
                       $sheet->setCellValueByColumnAndRow(7, $index, $row1[7]);
                       $sheet->setCellValueByColumnAndRow(8, $index, $row1[8]);
                       $sheet->setCellValueByColumnAndRow(9, $index, $row1[9]);
                       $sheet->setCellValueByColumnAndRow(10, $index, $row1[10]);
                       #$sheet->setCellValueByColumnAndRow(11, $index, $row1[11]);
                       $sheet->setCellValueByColumnAndRow(12, $index, $row1[11]);
                       $sheet->setCellValueByColumnAndRow(13, $index, $row1[12]);
                       $sheet->setCellValueByColumnAndRow(14, $index, $row1[13]);
                       $sheet->setCellValueByColumnAndRow(15, $index, $row1[14]);
                       $sheet->setCellValueByColumnAndRow(16, $index, $row1[15]);     
                       
                       $index++;
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
 $objWriter->save(str_replace(__FILE__,"/var/www/files/Norka_Rep/$date.xls",__FILE__)); 
 #$objWriter->save('php://output');
 $out = shell_exec('bash /home/it/scripts/Norka_rep.sh'); 
 #mail("it@int.dmcorp.ru", "subject", "FUCK", "gsot@dmcorp.ru");
     
  