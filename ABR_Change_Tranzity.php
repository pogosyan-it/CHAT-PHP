#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0; 
$DateOfRequest = date("Y-m-d").'_Tranzity.txt';
$head="Номер накладной           Дата               Изменение региона              Способ отправки                  Примечание";
$fd = fopen("/var/www/files/Tranzity/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Tranzity/$DateOfRequest"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
 #fwrite($fd, iconv("cp1251", "utf-8", $size."\r\n"));

    $result = mysqli_query($link,  "Select d15_departures.WayBillNum, d15_departures.SY_Adding,   d15_departures.ID, 
                                    a.Name as 'dest_adr', b.Name as 'dest_region', hbc_rChange.Region_abr, d00_buff.str67, d00_buff.str0F
                                    from d15_departures 
                                    left join hbc_cities on hbc_cities.ID=d15_departures.R_CityID
                                    left join hbc_divisions a on a.CityID=hbc_cities.ID
                                    left join hbc_divisions b on d15_departures.ToDivID=b.ID	
                                    left join hbc_rChange on hbc_rChange.id_city_adr=d15_departures.R_CityID
                                    left join d00_buff on d00_buff.dXXID=d15_departures.ID
                                    where 
                                    hbc_cities.id  in (Select hbc_rChange.id_city_adr from hbc_rChange) and a.Name<>b.Name 
                                    and d15_departures.WarehousID=0 and d15_departures.WayBillNum IS not NULL and d15_departures.SY_Void=0 and d15_departures.WayBillNum <>'Снят!' and b.Name 
                                    in (Select hbc_rChange.Region_abr from hbc_rChange)");
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
  
                  if  ($row[4] == $row[5] )    {
                   


                   $res=mysqli_query($link, "Select ID from hbc_divisions where hbc_divisions.Name='$row[3]' into @reg_id");
                  
                   $res=mysqli_query($link, "Update d15_departures SET d15_departures.ToDivID=@reg_id where d15_departures.Id='$row[2]'");
            
                   fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[0].'         '.$row[1].'            ' .$row[4].'   =>    '.$row[3].'            '.$row[7].'               '.$row[6]."\r\n"));  }
                  
                   $index++;

                   }
                       
      $res=mysqli_query($link, "Update d15_departures SET d15_departures.ToDivID='83' where d15_departures.R_CityID in ('3503', '3512','4397','4398','4399')");
fclose($fd);
                                                          }                                                     
                              
 ?>

