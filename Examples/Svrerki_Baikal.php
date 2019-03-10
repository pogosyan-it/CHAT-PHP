<?php

$link = new mysqli(
            "10.10.1.2",  // Хост, к которому мы подключаемся 
            "root",      // Имя пользователя  
            "2me32jvppn",    // Используемый пароль 
            "gsotldb");     // База данных для запросов по умолчанию  
$link->set_charset("cp1251");

$DateOfRequest=date("Y-m-d").'_Baikal'.'.txt';

$index=0;

$fd = fopen("/var/www/files/Sverki/Reports/Baikal/$DateOfRequest",'a+') or die("не удалось создать файл");
$output = shell_exec('scp root@10.10.1.4:/media/landisc/corp/TARIF/Tariff.xls /var/www/files/Sverki');
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

$file='/var/www/files/Sverki/Tariff.xls';
if (file_exists($file)) 
{ 
$excel = PHPExcel_IOFactory::load($file); 

Foreach($excel ->getWorksheetIterator() as $worksheet) 
{
 $lists[] = $worksheet->toArray();
}

$q=count($lists[0]);
#print('Q='.$q."\n");
for ($i = 1; $i <= $q-1; $i++) 
              
            {  
               $sum=$lists[0][$i][2];
               $waybill=iconv("utf-8","cp1251",$lists[0][$i][1]);
               $waight=$lists[0][$i][3]; 
               if (empty($waybill) or empty($sum)) { break; }
               else {  
               $symb_date  = '.';
               $date_delim = strpos($lists[0][$i][0], $symb_date);
               if ($date_delim===false) 
                   {
                     $date=explode("/", $lists[0][$i][0])[2].'-'.explode("/", $lists[0][$i][0])[0].'-'.explode("/", $lists[0][$i][0])[1];
                     
                   }
                else {
                      $date=explode(".", $lists[0][$i][0])[2].'-'.explode(".", $lists[0][$i][0])[1].'-'.explode(".", $lists[0][$i][0])[0];
                      
                      }  
               
               
              $res=mysqli_query($link, "Update d50_vo SET d50_vo.WayBillSumm='$sum', d50_vo.EWeightS='$waight' 
                                               where d50_vo.WayBill='$waybill' and d50_vo.lCargoHandedOver >='$date'");   
               
               $res=mysqli_query($link, "Select d50_vo.WayBill, d50_vo.lCargoHandedOver, d50_vo.WayBillSumm, d50_vo.EWeightS from d50_vo 
                                                    where d50_vo.WayBill='$waybill'");
                              
                                while ($row = mysqli_fetch_array($res, MYSQL_NUM))  
                                {
                                   if ($row[2]==$sum and $row[3]== $waight ) 
                                        {fwrite($fd, $i.'  '.iconv("cp1251", "utf-8",$row[0]).'         '.$row[1].'     '.$row[2].'    '.$row[3].'   '."TRUE"."\r\n");}
                                   else 
                                        {fwrite($fd, $i.'  '.iconv("cp1251", "utf-8",$row[0]).'         '.$row[1].'     '.$row[2].'    '.$row[3].'   '."FALSE"."\r\n");}        
                  
                                  $index++;
                                   

                                  }                          
                                     
                                   print_r($i.'  '.$waybill.'   '.$date.'     '.$sum.'     '.$waight."\n");
               
                       }
               }
  fclose($fd); 
  #$out = shell_exec('echo "См. вложение" | mail -s \'Отчеты Байкал\' -a /var/www/files/Sverki/Reports/Baikal/`date +%Y-%m-%d`_Baikal.txt -r "gsot@corp.ws" it@int.dmcorp.ru'); 
  #$out = shell_exec('echo "См. вложение" | mail -s \'Отчеты Байкал\' -a /var/www/files/Sverki/Reports/Baikal/`date +%Y-%m-%d`_Baikal.txt -r "gsot@corp.ws" gsverki@dmcorp.ru');
  $output = shell_exec('mv /var/www/files/Sverki/Tariff.xls /var/www/files/Sverki/Done/Baikal/Baikal_"`date \+\%Y_\%m_\%d_\%H_\%M`".xls');
   }
?>