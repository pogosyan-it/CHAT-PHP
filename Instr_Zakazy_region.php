#!/usr/bin/php 

 <?php  
$FilePHP = $_SERVER['PHP_SELF'];
include 'gsotldb.php';
$time = date("Hi");
$j=0;
    
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0;
$DateOfRequest1 = date("Y-m-d").'_More_Zakazy_Region'.'.txt';
$DateOfRequest2 = date("Y-m-d").'_Less_Zakazy_Region'.'.txt';

$head="Номер накладной           Номер Заказа            Дата               Спец. Инструкции";

if (!file_exists("/var/www/files/Zakazy_Instr/More/$DateOfRequest1"))  
        {
         $fd1 = fopen("/var/www/files/Zakazy_Instr/More/$DateOfRequest1",'a+') or die("не удалось создать файл");
         fwrite($fd1, iconv("cp1251", "utf-8", $head."\r\n"));
        }    
else    {
         $fd1 = fopen("/var/www/files/Zakazy_Instr/More/$DateOfRequest1",'a+') or die("не удалось создать файл");    
        }

if (!file_exists("/var/www/files/Zakazy_Instr/Less/$DateOfRequest2")) 
        {
         $fd2 = fopen("/var/www/files/Zakazy_Instr/Less/$DateOfRequest2",'a+') or die("не удалось создать файл");
         fwrite($fd2, iconv("cp1251", "utf-8", $head."\r\n"));
        }    
else    {
          $fd2 = fopen("/var/www/files/Zakazy_Instr/Less/$DateOfRequest2",'a+') or die("не удалось создать файл");
        } 


    $res = mysqli_query($link, "Select Date from PHP_Log where PHP_Log.ID=(Select MAX(ID) from PHP_Log where PHP_Log.`Values`='Spec Instruction update less 50 char') 
                                into @last_date");
    
    $result = mysqli_query($link,  "Select d15_departures.WayBillNum, d15_departures.PickUpCode,
                                    d15_departures.Sh_Instructions, d00_buff.str67, d15_departures.SY_Adding, d15_departures.ID
                                    from d15_departures
                                    left join d00_buff on d00_buff.dXXID=d15_departures.ID
                                    where d15_departures.FromDivID=1 and d15_departures.ToDivID<>1 and d15_departures.PickUpCode is not null
                                    and d15_departures.SY_Void=0 and d00_buff.str67 != '' and d00_buff.str67 !=',' 
                                    and d00_buff.str67 !='индивидуальный тариф'
                                    and d15_departures.WayBillNum not like '%!' and d15_departures.fSidePost=0 
                                    and d15_departures.Sh_Instructions not like '%\/%' 
                                    and d15_departures.SY_Adding >NOW() - Interval 7 day;");
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {

                          $length = strlen(utf8_decode($row[2].$row[3]));
                          $new_instr=$row[2].'/'.$row[3];
                     
                      if ($length > 100 & strcmp(mb_strtolower($row[2]), mb_strtolower($row[3]))<>0) 
                           {
                              
                              fwrite($fd1, iconv("cp1251", "utf-8", '  '.$row[0].'         '.$row[1].'       ' .$row[4].'        ' .$new_instr."\r\n"));
                              $j=$j+$index;
                              $row[3]=iconv("utf-8", "cp1251", 'См. Источник');
                              $new_instr=$row[2].'/'.$row[3];
                              
                              $res_up=mysqli_query($link, "Update d15_departures SET d15_departures.Sh_Instructions='$new_instr' where d15_departures.ID='$row[5]';");
                           }
                      
                      elseif ($length < 101 & strcmp(mb_strtolower($row[2]), mb_strtolower($row[3]))<>0) 
                         {
                              fwrite($fd2, iconv("cp1251", "utf-8", '  '.$row[0].'         '.$row[1].'       ' .$row[4].'        ' .$new_instr."\r\n"));
                              $res_up=mysqli_query($link, "Update d15_departures SET d15_departures.Sh_Instructions='$new_instr' where d15_departures.ID='$row[5]';");
                              
                              
                          }  
                    #echo  $row[0];                     
                   $index++;

                  }                
$result = mysqli_query($link,  "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', 'Server', '10.10.1.10', NOW(), 'Spec Inst for zakazy_reg update<50 char')");
if ($j>0) { 
        
       echo exec('echo "См. вложение" | mail -s \'Спец. Инструкции Заказов\' -a /var/www/files/Zakazy_Instr/More/`date +%Y-%m-%d`"_More_Zakazy_Region.txt" -r "gsot@corp.ws" smk@dmcorp.ru');
          }
else      { 
       
        echo exec('rm /var/www/files/Zakazy_Instr/More/`date +%Y-%m-%d`_More_Zakazy_Region.txt'); 
          } 
                  
                                                           } 
                                                                                    
fclose($fd1);
fclose($fd2);
                             
 ?>

