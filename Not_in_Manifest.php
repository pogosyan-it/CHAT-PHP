#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0; 
$index1=0;
$index2=0;
$n=0;
$m=0;
$DateOfRequest2 = date("Y-m-d").'_2_Manifest'.'.txt';
$DateOfRequest1 = date("Y-m-d").'_Not_in_Manifest'.'.txt';
$head="Номер накладной     Регион Отправления    Регион Получения     Вес     Кол-во мест";
$head2="Номер накладной    Кол-во манифестов";
$fd1 = fopen("/var/www/files/Not_in_Manifest/$DateOfRequest1",'a+') or die("не удалось создать файл");        //не в манифесте
$fd2 = fopen("/var/www/files/2_Manifest/$DateOfRequest2",'a+') or die("не удалось создать файл");            //2-х и более манифестах
$size1 = filesize("/var/www/files/Not_in_Manifest/$DateOfRequest1"); 
$size2 = filesize("/var/www/files/2_Manifest/$DateOfRequest2"); 
  if ($size1 < '1') {fwrite($fd1, iconv("cp1251", "utf-8", $head."\r\n")); }
  if ($size2 < '1') {fwrite($fd2, iconv("cp1251", "utf-8", $head2."\r\n")); }
 #fwrite($fd, iconv("cp1251", "utf-8", $size."\r\n"));
    $result = mysqli_query($link,  "Select Concat(DATE_FORMAT(NOW() - Interval 1 day, '%Y-%m-%d'),' ','00:00:00') into @t1;");
    $result = mysqli_query($link,  "Select Concat(DATE_FORMAT(NOW() - Interval 1 day, '%Y-%m-%d'),' ','23:59:59') into @t2;");

    $result = mysqli_query($link,  "Select d15_departures.WayBillNum,d30_manifests.ManifestNum, a.Name, b.Name, 
                                                 d15_departures.Sh_Weight, d15_departures.Sh_Place, d31_manifest2departure.SY_Void from d15_departures
                                          left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                                          left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                                          left join hbc_divisions a on a.ID=d15_departures.FromDivID
                                          left join hbc_divisions b on b.ID=d15_departures.ToDivID 
                                          where d15_departures.SY_Adding between @t1 and @t2 and d30_manifests.ToDiv <> 1 and d31_manifest2departure.SY_Void=1
                                          d15_departures.ToDivID <> 1 and d15_departures.WarehousID=1;");
                                      
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                  
                  $res=mysqli_query($link, "Select COUNT(*) from d15_departures
                                          left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                                          left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                                          left join hbc_divisions a on a.ID=d15_departures.FromDivID
                                          left join hbc_divisions b on b.ID=d15_departures.ToDivID 
                                          where 
														d30_manifests.ToDiv <> 1 and d31_manifest2departure.SY_Void=0
                                                        and d15_departures.WarehousID=1 and d15_departures.WayBillNum='$row[0]'");
                              
                                while ($row1 = mysqli_fetch_array($res, MYSQL_NUM))   {
                  
                                       if ($row1[0]==0) {
            
                       fwrite($fd1, iconv("cp1251", "utf-8", '  '.$row[0].'              '.$row[2].'                '.$row[3].'                 '.$row[4].'            '.$row[5]."\r\n"));
                                                         }
                  
                   $index1++;

                   }
               
                      
                            $index++;
                  }     
                            fclose($fd1); 
                           
 $result = mysqli_query($link,  "Select d15_departures.WayBillNum, COUNT(*) from d15_departures
                                left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                                left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                                left join hbc_divisions a on a.ID=d15_departures.FromDivID
                                left join hbc_divisions b on b.ID=d15_departures.ToDivID 
                                where 
                                d30_manifests.ToDiv <> 1 and d31_manifest2departure.SY_Void=0 and d15_departures.SY_Adding between @t1 and @t2
                                and d15_departures.WarehousID=1 group by d15_departures.WayBillNum having COUNT(d15_departures.WayBillNum) > 1;");                                      
 while ($row1 = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {  
                  
                  
 fwrite($fd2, iconv("cp1251", "utf-8", '  '.$row1[0].'              '.$row1[1]."\r\n"));    
 
                         $index2++;             
                  
                  
                  } 
                           fclose($fd2);                            
                                               }                                               
                              
 ?>

