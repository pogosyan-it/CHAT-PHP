#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$date=date("Y-m-d");
$dir1 = "/var/www/files/BH_MOW_DOCK/MOW/$date";
$dir2 = "/var/www/files/BH_MOW_DOCK/DOCK/$date";
if(!is_dir($dir1)) mkdir($dir1);
if(!is_dir($dir2)) mkdir($dir2);
#mkdir("/var/www/files/BH_MOW/$date");
$index=0;
$index1=0; 
$DateOfRequest_MOW = 'BH_MOW'.'.txt';
$DateOfRequest_DOCK = 'BH_DOCK'.'.txt';
$head="����� ���������      ����� ������             ����                       ���          ����. ����������               �������    ";
$fd = fopen("/var/www/files/BH_MOW_DOCK/MOW/$date/$DateOfRequest_MOW",'a+') or die("�� ������� ������� ����");
$size = filesize("/var/www/files/BH_MOW_DOCK/MOW/$date/$DateOfRequest_MOW"); 
  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
  
  $result = mysqli_query($link,  "Select d15_departures.ID, d15_departures.SY_Adding, d15_departures.WayBillNum, 
                                  d15_departures.PickUpCode, hbc_routes.Name, d15_departures.Sh_Weight, d15_departures.Sh_Instructions
                             
                                  from d15_departures 
                                  
                                  left join hbc_routes on hbc_routes.ID=d15_departures.R_RouteID 
                                  left join hbc_cities on hbc_cities.ID=d15_departures.R_CityID
                                  left join d00_buff on d00_buff.dXXID=d15_departures.ID
                                  where 
                                  d15_departures.ToDivID='1' and d15_departures.SY_OwnDiv='2' and d15_departures.Sh_Weight >='100' 
                                  and hbc_cities.FedUnitID in ('21', '29') and d15_departures.R_RouteID != '60'
                                  or 
                                  d15_departures.ToDivID='1' and d15_departures.SY_OwnDiv='2' and  hbc_cities.FedUnitID in ('21', '29') 
                                  and d15_departures.Sh_Instructions like '%��������%�����%' and d15_departures.R_RouteID != '60'
                                  or 
                                  d15_departures.ToDivID='1' and d15_departures.SY_OwnDiv='2' and  hbc_cities.FedUnitID in ('21', '29') 
                                  and d00_buff.str67 like '%��������%�����%' and d15_departures.R_RouteID != '60';");
                                                      while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
     
                  $res=mysqli_query($link, "Update d15_departures SET d15_departures.R_RouteID='60' where d15_departures.ID='$row[0]'");
                  fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[2].'           '.$row[3].'             ' .$row[5].'               ' .$row[6].'            ' .$row[4].'    =>    '.'BH.MOW'."\r\n"));
                                                                      
                 $index++;
                  }
                 
                   fclose($fd);                 

$fd1 = fopen("/var/www/files/BH_MOW_DOCK/DOCK/$date/$DateOfRequest_DOCK",'a+') or die("�� ������� ������� ����");
$size1 = filesize("/var/www/files/BH_MOW_DOCK/DOCK/$date/$DateOfRequest_DOCK"); 

if ($size1 < '1') {fwrite($fd1, iconv("cp1251", "utf-8", $head."\r\n")); }
  
  $result = mysqli_query($link,  "Select d15_departures.ID, d15_departures.SY_Adding, d15_departures.WayBillNum, 
                                 d15_departures.PickUpCode, hbc_routes.Name, d15_departures.Sh_Weight, d15_departures.Sh_Instructions 
                                 from d15_departures
                                 left join hbc_routes on hbc_routes.ID=d15_departures.R_RouteID
                                 where d15_departures.R_Name REGEXP '^[^�-��-�]{0,1}��.*���[[:>:]]' and d15_departures.ToDivID in ('1','130') and d15_departures.R_RouteID<>'255' and d15_departures.SY_Void=0
                                 or d15_departures.R_Name REGEXP  '����.*���.{0,1}$' and d15_departures.ToDivID in ('1','130') and d15_departures.R_RouteID<>'255' and d15_departures.SY_Void=0
                                 or d15_departures.R_Name like '%����%'and d15_departures.R_Name rlike '[[:<:]][:space:]���[[:>:]]' and d15_departures.ToDivID in ('1','130') and d15_departures.R_RouteID<>'255' and d15_departures.SY_Void=0
                                 or d15_departures.R_Name like '%����%-���%'and d15_departures.ToDivID in ('1','130') and d15_departures.R_RouteID<>'255' and d15_departures.SY_Void=0
                                 or d15_departures.R_Name like '%����%-���%' and d15_departures.ToDivID in ('1','130') and d15_departures.R_RouteID<>'255' and d15_departures.SY_Void=0;");
                                                      while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
     
                  $res=mysqli_query($link, "Update d15_departures SET d15_departures.R_RouteID='255' where d15_departures.ID='$row[0]'");
                  fwrite($fd1, iconv("cp1251", "utf-8", '  '.$row[2].'           '.$row[3].'             ' .$row[5].'               ' .$row[6].'            ' .$row[4].'    =>    '.'BH.DIS'."\r\n"));
                                                                      
                 $index1++;
                  }


if ( $index1 > 0 or  $index > 0)  {
                      $out = shell_exec('bash /home/it/scripts/mail_BH_MOW_DOCK.sh');
                   }
#var_dump($out);                 
                   fclose($fd1);
                   

                                                          }                                                     
                              
 ?>