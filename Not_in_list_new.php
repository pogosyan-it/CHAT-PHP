#!/usr/bin/php 

 <?php  
$last_edit=date('Y-m-d', strtotime( ' -1 day'));
echo $last_edit=$last_edit.' 13:30:00';
include 'gsotldb.php';
$time = date("Hi");
if (  $time > '0010' && $time < '1600' || $time > '1610' ) { 
$index=0; 
$index1=0;
$index2=0;
$DateOfRequest2 = date("Y-m-d").'_Not_Assign'.'.txt';
$DateOfRequest1 = date("Y-m-d").'_Not_in_List'.'.txt';
$head1="Номер накладной        Маршрут листа           ФИО Курьера         Маршрут доставки";
$head="Номер накладной           Дата выдачи листа";
$fd1 = fopen("/var/www/files/Not_in_List/$DateOfRequest1",'a+') or die("не удалось создать файл");
$fd2 = fopen("/var/www/files/Not_assign/$DateOfRequest2",'a+') or die("не удалось создать файл");
$size1 = filesize("/var/www/files/Not_in_List/$DateOfRequest1"); 
$size2 = filesize("/var/www/files/Not_assign/$DateOfRequest2"); 
  if ($size1 < '1') {fwrite($fd1, iconv("cp1251", "utf-8", $head1."\r\n")); }
  if ($size2 < '1') {fwrite($fd2, iconv("cp1251", "utf-8", $head."\r\n")); }
 #fwrite($fd, iconv("cp1251", "utf-8", $size."\r\n"));
    $res_date = mysqli_query($link,  "Select NOW() - Interval 1 Day into @last_edit;");
    $res_month = mysqli_query($link,  "Select NOW() - Interval 1 month into @inter;");

    $result = mysqli_query($link,     "SELECT distinct d15_departures.WayBillNum
                                      FROM d20_extask
                                      left join d15_departures on d20_extask.dXXID=d15_departures.ID
                                      left join hbc_extaskstates on hbc_extaskstates.ID=d20_extask.stateKey
                                      left join d21_extasklist on d21_extasklist.ID=d20_extask.d21ID
                                      where d15_departures.SY_Adding > @inter and d15_departures.R_RouteID not in ('60', '255','127')
                                      and d15_departures.fSidePost=0 and d15_departures.SY_Void=0
                                      and d20_extask.ExTimeStamp is not NULL and hbc_extaskstates.ID not in
                                      ('7','1') and d15_departures.WayBillNum is not NULL and d15_departures.ToDivID =1
                                      and d15_departures.WayBillNum not like '%!' and 
                                      d20_extask.SY_Adding < @last_edit and d21_extasklist.SY_Adding < @last_edit;");
 
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                
                  $res=mysqli_query($link, "SELECT Count(d15_departures.WayBillNum)
            
                                            FROM d20_extask
                                            left join d15_departures on d20_extask.dXXID=d15_departures.ID
                                            left join hbc_extaskstates on hbc_extaskstates.ID=d20_extask.stateKey
                                            where d15_departures.WayBillNum = '$row[0]'
                                            and d20_extask.stateKey='7' and d15_departures.ToDivID='1'");
                              
                                while ($row1 = mysqli_fetch_array($res, MYSQL_NUM))   {
                  
                                       if ($row1[0]==0) {
                                       
                   $result2 = mysqli_query($link,     "SELECT d15_departures.WayBillNum, a.Name, hb_employee.SName, b.Name, d21_extasklist.SY_Adding
                                                      FROM d20_extask
                                                      left join d15_departures on d20_extask.dXXID=d15_departures.ID
                                                      left join hbc_extaskstates on hbc_extaskstates.ID=d20_extask.stateKey
                                                      left join d21_extasklist on d21_extasklist.ID=d20_extask.d21ID
                                                      left join hb_employee on hb_employee.ID=d21_extasklist.employeeID
                                                      left join hbc_routes a on a.ID=d21_extasklist.routeID
                                                      left join hbc_routes b on b.ID=d15_departures.R_RouteID
                                      
                                                       where d15_departures.WayBillNum='$row[0]' order by d21_extasklist.SY_Adding desc  limit 1");
                                                        
                   
                   while ($row2 = mysqli_fetch_array($result2, MYSQL_NUM)) 
                  {
                   if ($row2[4]<$last_edit)  {
                  fwrite($fd1, iconv("cp1251", "utf-8", '  '.$row2[0].'         '.$row2[1].'        '.$row2[2].'        '.$row2[3]."\r\n"));}
                                              }
                      $index2++;
                     }
                  
                                $index1++;

                                }
                                          $index++;
                                                        }     
                            fclose($fd1);    
                                       
 $result = mysqli_query($link,     "Select d15_departures.WayBillNum,d15_departures.SY_Adding  from d15_departures 
                                    where d15_departures.SY_Void=0 and d15_departures.ToDivID=1 and d15_departures.WarehousID=1 and d15_departures.fSidePost<>1
                                    and d15_departures.ID not in (Select d20_extask.dXXID from d20_extask where d20_extask.SY_Void=0)
                                    and d15_departures.SY_Adding > (Select NOW() - Interval 1 month)");   
                                    
                         while ($row2 = mysqli_fetch_array($result, MYSQL_NUM))
                          {
                         
                          fwrite($fd2, iconv("cp1251", "utf-8", '  '.$row2[0].'         '.$row2[1]."\r\n")); 
                          $index2++;
                         }              
                               fclose($fd2);                                 
                                               }                                               
                              
 ?>

