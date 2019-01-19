#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0;
$j=0;
$DateOfRequest = date("Y-m-d").'.txt';
$head="п/п   Номер заказа      Номер накладной          Маршрут         Офис Доставки         Офис Оплаты           Выполнено/Не выполнено      Поступила / не поступила";

$fd = fopen("/var/www/files/3th_city/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/3th_city/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
 #fwrite($fd, iconv("cp1251", "utf-8", $size."\r\n"));

    $result = mysqli_query($link,  "Select d15_departures.PickUpCode,d15_departures.PaymentTXT,hbc_cities.Name, d15_departures.PickUpRTime,
                                     d15_departures.WayBillNum, hbc_routes.Name, hbc_divisions.Name from  d15_departures 
                                    left join hbc_divisions on hbc_divisions.ID=d15_departures.ToDivID
                                    left join hbc_cities on hbc_cities.ID=hbc_divisions.CityID
                                    left join hbc_routes on hbc_routes.ID=d15_departures.S_RouteID
                                    where d15_departures.SY_Void=0 and d15_departures.PickUpCode is not null
                                    and Date_Format(d15_departures.PickUpRTime, '%Y-%m-%d')=Date_Format(NOW(), '%Y-%m-%d') 
                                    and d15_departures.SY_OwnDiv<>d15_departures.ToDivID and d15_departures.FromDivID=1
                                    or
                                    Date_Format(d15_departures.PickUpRTime, '%Y-%m-%d')=Date_Format(NOW(), '%Y-%m-%d')  and d15_departures.SY_Void=0 and
                                    SUBSTRING_INDEX(hbc_cities.Name, '(', 1)<>d15_departures.PaymentTXT and d15_departures.FromDivID=1 and 
                                    d15_departures.SY_OwnDiv=d15_departures.ToDivID and d15_departures.PickUpCode is not null");
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                   if ($row[4] !== 'Снят!') { $j=$index+1;
                   
                   if  ($row[1] !== 'КОРП' )    {fwrite($fd, iconv("cp1251", "utf-8", $j.'    '.$row[0].'             ' .$row[4].'                      '.$row[5].'              '.$row[6].'               '.$row[1].'            '."\r\n"));  }
                                              #{fwrite($fd, iconv("cp1251", "utf-8", $row[0]."\r\n")); }                                                                                  
                  elseif ($row[1] == 'КОРП' and $row[2] !== 'Москва') {fwrite($fd, iconv("cp1251", "utf-8", $j.'    '.$row[0].'             ' .$row[4].'              '.$row[5].'              '.$row[6].'               '.$row[1].'            '."\r\n")); } 
                                                                       # {fwrite($fd, iconv("cp1251", "utf-8", $row[0]."\r\n")); } 
                                                 
                                           }
                   $index++;

                   }
      
fclose($fd);
                                                          }                                                     
                              
 ?>

