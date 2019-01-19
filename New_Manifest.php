#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
$DateOfRequest=date("Y-m-d").'_New_Manifest'.'.txt';
$head="Номер манифеста    Регион Получения      Номер Накладной        Способ отправки";
$index=0; 
$index1=0; 
$fd = fopen("/var/www/files/NewManifest/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/NewManifest/$DateOfRequest");
if ($size < '1') {fwrite($fd, $head."\r\n"); }
    $result = mysqli_query($link,  "SELECT d15_departures.WayBillNum
                                    FROM d15_departures 
                                    left join log_edit on log_edit.FieldID=d15_departures.ID 
                                    left join hb_employee on log_edit.SY_MembID=hb_employee.ID 
                                    WHERE log_edit.lValues like '%WarehousID== 0%' and log_edit.Created_Time between NOW() - Interval 360 hour 
                                    and NOW() - Interval 48 hour and  log_edit.TablID=15 and d15_departures.SY_Void = 0;");
                                      
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                  
                    $res=mysqli_query($link, "SELECT  d30_manifests.ManifestNum, hbc_divisions.Name, d15_departures.WayBillNum, d15_departures.Ser_type
                                              FROM d15_departures 
                                              left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                                              left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                                              left join hbc_divisions on hbc_divisions.ID=d30_manifests.ToDiv
                                              WHERE d30_manifests.ManifestNum like 'NEW%' and d31_manifest2departure.SY_Void=0  and d30_manifests.ToDiv <> 1  
                                              and d30_manifests.SY_Void=0 and hbc_divisions.Name not in ('ZGR', 'CORP', 'MOW', 'DOC', 'TRNS', 'TAS')  and 
                                              hbc_divisions.CountryID<>'173' and d15_departures.WayBillNum='$row[0]'");
                           while ($row1 = mysqli_fetch_array($res, MYSQL_NUM))   {                   
                  
                  if ($row1[3]==0) {$row1[3]='экспресс';}
                  else {$row1[3]='эконом';}

                       fwrite($fd, $row1[0].'              '.$row1[1].'                 '.$row1[2].'               '.$row1[3]."\r\n");
                                                         
                            $index1++;
                  }     
                 $index=0;         
                          
                 }                              
                   fclose($fd);            
 ?>

