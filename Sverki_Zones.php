#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0; 
$DateOfRequest = date("Y-m-d").'.txt';
$head="Номер накладной           Дата               Изменение региона";
$fd = fopen("/var/www/files/Sverki_Zones/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Sverki_Zones/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
 #fwrite($fd, iconv("cp1251", "utf-8", $size."\r\n"));

    $result = mysqli_query($link,  "");
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                // print($row[0][2]);
               
                   $waybill[$index]=$row[0];
                   $date[$index]=$row[1];
                   $ID[$index]=$row[2];
                   $dest_adr[$index]=$row[3];
                   $dest_region[$index]=$row[4];
                   
                  if  ($row[4] == $row[5] )    {
                   


                   $res=mysqli_query($link, "Select ID from hbc_divisions where hbc_divisions.Name='$row[3]' into @reg_id");
                  
                  # $res=mysqli_query($link, "Update d15_departures SET d15_departures.ToDivID=@reg_id where d15_departures.Id='$row[2]'");
            
                   fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[0].'         '.$row[1].'       ' .$row[4].'   =>    '.$row[3]."\r\n"));  }
                  
                   $index++;

                   }
      #$res=mysqli_query($link, "Update d15_departures SET d15_departures.ToDivID='83' where d15_departures.R_CityID in ('3503', '3512','4397','4398','4399')");
fclose($fd);
                                                          }                                                     
                              
 ?>