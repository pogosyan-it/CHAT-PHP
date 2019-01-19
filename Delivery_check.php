#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0; 
$index1=0; 
$DateOfRequest = date("Y-m-d").'.txt';
$head="Номер накладной           Дата           Город_Отправитель       Вес        Кол-во Мест           Дата_Доставки                 Получатель";
$fd = fopen("/var/www/files/Delivery_check/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Delivery_check/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
 #fwrite($fd, iconv("cp1251", "utf-8", $size."\r\n"));

    $result = mysqli_query($link,  "SELECT a.WayBillNum
                                    FROM d20_extask
                                    left join d15_departures a on d20_extask.dXXID=a.ID
                                    left join hbc_extaskstates on hbc_extaskstates.ID=d20_extask.stateKey
                                    
                                    where d20_extask.SY_Adding>NOW() - Interval 31 DAY
                                    and d20_extask.stateKey='7' and d20_extask.cpName not in ('NULL','') and d20_extask.SY_Void = 0
                                    and a.WayBillNum is not NULL and a.ToDivID in ('1','49','59','104','130')
                                    and d20_extask.cpName not in ('не отп','отп')  GROUP BY a.WayBillNum HAVING count(a.WayBillNum)>1 ");
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                        
                               $res=mysqli_query($link, "Select d15_departures.WayBillNum, d15_departures.SY_Adding, hbc_divisions.Name, d15_departures.Sh_Weight, d15_departures.Sh_Place, 
                                                         d20_extask.ExTimeStamp, d20_extask.cpName from d15_departures
                                                  
                                                          left join hbc_divisions on hbc_divisions.ID=d15_departures.FromDivID
                                                          
                                                          left join d20_extask on d20_extask.dXXID=d15_departures.ID
                                                          where d15_departures.WayBillNum='$row[0]' and d20_extask.ExTimeStamp is not NULL");
                              
                                while ($row1 = mysqli_fetch_array($res, MYSQL_NUM)) 
                              {

                               fwrite($fd, iconv("cp1251", "utf-8", '  '.$row1[0].'         '.$row1[1].'           ' .$row1[2].'             '.$row1[3].'             '.$row1[4].'              '.$row1[5].'              '.$row1[6]."\r\n"));  
                              
                               $index1++;
            
                               }
            
                   $index++;

                   }
      
fclose($fd);
                                                          }                                                     
                              
 ?>

