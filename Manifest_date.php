#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$time = date("Hi");
$DateOfRequest=date("Y-m-d").'_Mandate'.'.txt';
$head="Номер манифеста       Дата";
$index=0; 
$fd = fopen("/var/www/files/Mandate/$DateOfRequest",'a+') or die("не удалось создать файл");
$size = filesize("/var/www/files/Mandate/$DateOfRequest");
if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
    $result = mysqli_query($link,  "Select d30_manifests.ManifestNum, d30_manifests.ManifestDate from d30_manifests where d30_manifests.ManifestNum 
                                    like 'new%' and d30_manifests.SY_Void = 0 and d30_manifests.ToDiv <> 1 and 
                                    d30_manifests.ManifestDate = date_format(NOW() - Interval 1 day, '%Y-%m-%d');");
                                      
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                  
                  $res=mysqli_query($link, "Update d30_manifests SET d30_manifests.ManifestDate=date_format(NOW(), '%Y-%m-%d') where d30_manifests.ManifestNum='$row[0]'");

                       fwrite($fd, iconv("cp1251", "utf-8", '  '.$row[0].'              '.$row[1]."\r\n"));
                                                         
                       $index++;
                  }     
                          
                    fclose($fd);       
                                               
                              
 ?>

