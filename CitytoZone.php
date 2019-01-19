#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$date=date("Y-m-d");
mkdir("/var/www/files/Sverki_Zones/$date");
                  
$index=0; 
$DateOfRequest = 'ToZoneNA'.'.txt';
$head="Номер накладной           Дата               Изменение зоны";
$fd = fopen("/var/www/files/Sverki_Zones/$date/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Sverki_Zones/$date/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
  
  $result = mysqli_query($link,  "Select d15_departures.ID, d15_departures.WayBillNum, d15_departures.SY_Adding, d15_departures.ToZone from d15_departures
                                  where d15_departures.WayBillNum != 'Снят!' and d15_departures.ToDivID=1 and d15_departures.R_CityID not
                                  in (Select hbc_cities.ID from hbc_cities where hbc_cities.ZoneID<>0) and d15_departures.R_CityID <> '2' and d15_departures.SY_Void='0'
                                  and d15_departures.SY_Adding>NOW()-Interval 1 day");
                                                      while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
     
                 $res=mysqli_query($link, "Update d15_departures SET d15_departures.ToZone='0' where d15_departures.ID='$row[0]'");
                  fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[1].'         '.$row[2].'       ' .$row[3].'   =>    '.'N/A'."\r\n"));                                                      
                 $index++;
                  }
                   fclose($fd);
                   
$index1=0;
$DateOfRequest = 'FromeZoneNA'.'.txt';
$head="Номер накладной           Дата               Изменение зоны";
$fd = fopen("/var/www/files/Sverki_Zones/$date/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Sverki_Zones/$date/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); } 
  
  $result = mysqli_query($link,  "Select d15_departures.ID, d15_departures.WayBillNum, d15_departures.SY_Adding, d15_departures.FromZone from d15_departures
                                  where d15_departures.WayBillNum != 'Снят!' and d15_departures.FromDivID=1 and d15_departures.S_CityID not
                                  in (Select hbc_cities.ID from hbc_cities where hbc_cities.ZoneID<>0) and d15_departures.S_CityID <> '2' and d15_departures.SY_Void='0'
                                  and d15_departures.SY_Adding>NOW()-Interval 1 day");
                                                      while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
     
                 $res=mysqli_query($link, "Update d15_departures SET d15_departures.FromeZone='0' where d15_departures.ID='$row[0]'");
                  fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[1].'         '.$row[2].'       ' .$row[3].'   =>    '.'N/A'."\r\n"));                                                      
                 $index1++;
                  }  
                 fclose($fd);
                                
$index2=0; 
$DateOfRequest = 'ToZone'.'.txt';
$head="Номер накладной           Дата               Изменение зоны";
$fd = fopen("/var/www/files/Sverki_Zones/$date/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Sverki_Zones/$date/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); } 
  
  $result = mysqli_query($link,   "Select d15_departures.ID, d15_departures.WayBillNum, d15_departures.SY_Adding, d15_departures.R_CityID, hbc_cities.ID,
                                    d15_departures.ToZone, hbc_cities.ZoneID
                                    from hbc_cities
                                    left join d15_departures on d15_departures.R_CityID=hbc_cities.ID
                                    where d15_departures.ToZone!=hbc_cities.ZoneID and d15_departures.WayBillNum != 'Снят!' 
                                    and d15_departures.ToDivID=1 and d15_departures.R_CityID <> 2 and d15_departures.SY_Adding>NOW()-Interval 1 day");
                                                      while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
     
                $res=mysqli_query($link, "Update d15_departures SET d15_departures.ToZone='$row[6]' where d15_departures.ID='$row[0]'");
                  fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[1].'         '.$row[2].'       ' .$row[5].'   =>    '.$row[6]."\r\n"));                                                      
                $index2++;
                  }
                   fclose($fd);
  
$index3=0; 
$DateOfRequest = 'FromZone'.'.txt';              
$fd = fopen("/var/www/files/Sverki_Zones/$date/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Sverki_Zones/$date/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }     
           
        $res = mysqli_query($link,  "select d15_departures.ID, d15_departures.WayBillNum, d15_departures.SY_Adding, d15_departures.S_CityID, hbc_cities.ID,
                                      d15_departures.FromZone, hbc_cities.ZoneID
                                      from hbc_cities
                                      left join d15_departures on d15_departures.S_CityID=hbc_cities.ID
                                      where d15_departures.FromZone!=hbc_cities.ZoneID and d15_departures.WayBillNum != 'Снят!' and d15_departures.FromDivID=1
                                      and d15_departures.SY_Adding>NOW()-Interval 1 day and d15_departures.S_CityID<>2");
                                                      while ($row = mysqli_fetch_array($res, MYSQL_NUM)) 
                                                       {
                     
                 $res1=mysqli_query($link, "Update d15_departures SET d15_departures.FromZone='$row[6]' where d15_departures.ID='$row[0]'");
                     fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[1].'         '.$row[2].'       ' .$row[5].'   =>    '.$row[6]."\r\n"));                                                       
                  
                   $index3++;

                   }
                   fclose($fd);

                                                          }                                                     
                              
 ?>