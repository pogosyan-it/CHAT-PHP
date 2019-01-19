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
$DateOfRequest = date("Y-m-d").'_2_upload'.'.txt';

$head="Номер накладной     Регион Отправления    Регион Получения     Вес     Кол-во мест";

$fd = fopen("/var/www/files/Upload/$DateOfRequest",'a+') or die("не удалось создать файл");        //не в манифесте

$size = filesize("/var/www/files/Upload/$DateOfRequest"); 

  if ($size < '1') {fwrite($fd, iconv("cp1251", "utf-8", $head."\r\n")); }
 
 #fwrite($fd, iconv("cp1251", "utf-8", $size."\r\n"));
    $result = mysqli_query($link,  "Select NOW() - Interval 5 hour into @t;");


    $result = mysqli_query($link,  "Select d15_departures.WayBillNum, d15_departures.PickUpCode,
                                    d15_departures.SY_Adding, d00_buff.SY_LastEdit, d15_departures.ToDivID, d15_departures.FromDivID, d00_buff.str04
                                    from d15_departures
                                    left join d00_buff on d00_buff.dXXID=d15_departures.ID
                                    where UNIX_TIMESTAMP(d00_buff.SY_LastEdit) - UNIX_TIMESTAMP(d15_departures.SY_Adding ) > '3600'
                                    and d00_buff.SY_LastEdit>@t and d15_departures.WayBillNum not like '%!' and d15_departures.SY_Void=0;");
                                      
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                      if ( $row[4]=='1' and empty($row[6]) )   //Доставки
                      
                         {
                           $res1 = mysqli_query($link,    "Select d00_buff.str01, d00_buff.str02, d00_buff.str03,  d00_buff.str07,
                                                           d00_buff.str27, d00_buff.str28, d00_buff.str29, d00_buff.str30, d00_buff.str33
                                                           from d00_buff where d00_buff.str01='$row[0]';");
                                 while ($row1 = mysqli_fetch_array($res1, MYSQL_NUM))                        
                      
                                 {
                                             $row1[2]=iconv("cp1251", "utf-8", $row1[2]);         
                                             $row1[3]=iconv("cp1251", "utf-8", $row1[3]);
                                             $row1[4]=iconv("cp1251", "utf-8", $row1[4]);         
                                             $row1[5]=iconv("cp1251", "utf-8", $row1[5]);
                                             $row1[6]=iconv("cp1251", "utf-8", $row1[6]);         
                                             $row1[7]=iconv("cp1251", "utf-8", $row1[7]);
                                             $row1[8]=iconv("cp1251", "utf-8", $row1[8]);
                                    print_r($row1[0].'  '.$row1[1].'  '.$row1[2].'  '.$row1[3].'  '.$row1[4].'  '.$row1[5].'  '.$row1[6].'  '.$row1[7].'  '.$row1[8]."\n");
                                     $index++;
                                  }                           
                          }
                                
                      

                 # fwrite($fd, '  '.iconv("cp1251", "utf-8", '  '.$row[0]).'              '.iconv("cp1251", "utf-8", '  '.$row[1]).'                '.$row[2].'          '.$row[3]."\r\n");
                  
                   $index1++;

                   }
 
                  }     
                            #fclose($fd); 
                           
                                            
    #iconv("cp1251", "utf-8", $row[1])                            
 ?>

