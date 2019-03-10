<?php

$link = new mysqli(
            "10.10.1.2",  // Хост, к которому мы подключаемся 
            "root",      // Имя пользователя  
            "2me32jvppn",    // Используемый пароль 
            "gsotldb");     // База данных для запросов по умолчанию  
$link->set_charset("cp1251");

$DateOfRequest=date("Y-m-d").'_Transport'.'.txt';

$index=0;
$index1=0;
$fd = fopen("/var/www/files/Sverki/Reports/$DateOfRequest",'a+') or die("не удалось создать файл");
$output = shell_exec('scp root@10.10.1.4:/media/landisc/corp/TARIF/transport.xls /var/www/files/Sverki');
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

$file='/var/www/files/Sverki/transport.xls';
if (file_exists($file)) 
{ 
$excel = PHPExcel_IOFactory::load($file); 

Foreach($excel ->getWorksheetIterator() as $worksheet) 
{
 $lists[] = $worksheet->toArray();
}

$q=count($lists[0]);
#print('Q='.$q."\n");
for ($i = 0; $i <= $q-1; $i++) 
              
            {  
               $waybill=$lists[0][$i][1];
               $sum=$lists[0][$i][2];
               if (empty($waybill) or empty($sum)) { break; }
               else { 
                     $symb_date  = '.';
                     $date_delim = strpos($lists[0][$i][0], $symb_date);
               if ($date_delim===false) 
                   {
                     $date=explode("/", $lists[0][$i][0])[2].'-'.explode("/", $lists[0][$i][0])[0].'-'.explode("/", $lists[0][$i][0])[1];
                     
                   }
                else {
                      $date=explode(".", $lists[0][$i][0])[2].'-'.explode(".", $lists[0][$i][0])[1].'-'.explode(".", $lists[0][$i][0])[0];;
                      
                      }   
              
               
               
               $find_symb  = '-';
               $pos1 = strpos($lists[0][$i][1], $find_symb);
               
               if ($pos1 === false ) {
                     $waybill_new_1='%'.$waybill;
                     
                     print_r($i.' '.$lists[0][$i][1].' '.$waybill_new_1."\n");
                     
                     $res=mysqli_query($link, "update d50_vo SET d50_vo.WayBillSumm='$sum' where d50_vo.WayBill like '$waybill_new_1' 
                                              and d50_vo.lCargoHandedOver >= '$date';");   
                     
                     $res=mysqli_query($link, "Select d50_vo.WayBill, d50_vo.lCargoHandedOver, d50_vo.WayBillSumm from d50_vo 
                                                    where d50_vo.WayBill like '$waybill_new_1'");
                              
                                while ($row = mysqli_fetch_array($res, MYSQL_NUM))  
                                {
                  
                                  fwrite($fd, iconv("cp1251", "utf-8", '  '.$i.'  '.$row[0].'         '.$row[1].'     '.$row[2]."\r\n"));  
                  
                                  $index++;

                                  }
   
                                   } 
               else  {
                      
                      $waybill_new_2 = explode("-", $lists[0][$i][1])[0].'%'.explode("-", $lists[0][$i][1])[1];
                      $res=mysqli_query($link, "update d50_vo SET d50_vo.WayBillSumm='$sum' where d50_vo.WayBill like '$waybill_new_2'  
                                                and d50_vo.lCargoHandedOver >= '$date'");
                      $res=mysqli_query($link, "Select d50_vo.WayBill, d50_vo.lCargoHandedOver, d50_vo.WayBillSumm from d50_vo 
                                                    where d50_vo.WayBill like '$waybill_new_2'");
                              
                                while ($row = mysqli_fetch_array($res, MYSQL_NUM))  
                                {
                  
                                  fwrite($fd, iconv("cp1251", "utf-8", '  '.$i.'  '.$row[0].'         '.$row[1].'     '.$row[2]."\r\n"));  
                  
                                  $index1++;

                                  }                          
                      print_r($i.' '.$waybill.'  '.$waybill_new_2.' '.$date.' '.$lists[0][$i][2]."\n");
                    }      
                   }
            }                    
$output = shell_exec('mv /var/www/files/Sverki/transport.xls /var/www/files/Sverki/Done/Transport/transport_"`date \+\%Y_\%m_\%d_\%H_\%M`".xls');

#echo shell_exec('bash /home/it/scripts/sverki_rep.sh');  
fclose($fd);          
}
else 
{
    echo "Файл $file не существует";
    fwrite($fd, "Файл $file не существует");
} 
 




?>