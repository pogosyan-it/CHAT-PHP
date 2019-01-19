<?php        
include 'courier2008.php';   
$index=0;
$index1=0;
$num=0; 
$date_now=date("Y-m-d");
$DateOfRequest ='return_list_'. $date_now.'.txt';
$f_d = fopen("/var/www/files/DOCK_reports/Grastin/P_Return/Returns/$DateOfRequest",'a+') or die("не удалось создать файл");
$result = mysqli_query($link,  "select boxes.Code, boxes.address, boxes.Price, boxes.Name from boxes 
                                left join address on address.code = boxes.address where address.client_id='$waybill[$i]';");
                                      
          while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
          {
                      #print_r($waybill[$i].' '.$row[3].' '.$return."\n");
              if ( $return==1 and $row[3]==$g_name[$j]) 
              {
     
                     $res=mysqli_query($link, "select COUNT(Box) from `returns` 
                                              left join boxes on boxes.code = `returns`.Box where boxes.Code='$row[0]';");
                              
                          while ($row1 = mysqli_fetch_array($res, MYSQL_NUM))   
                          {    
                              $num=$row1[0];
                              $index1++;
                           } 
                      #print_r($waybill[$i].' '.$g_name[$j].' '.$num."\n");          
              if ( $num==1) {print_r($num.' ' .$waybill[$i].' '.iconv("cp1251", "utf-8", $row[3])."\n"); 
                                 #fwrite($fd, 'Запись на возврат уже есть в БД Курьер'.'  '.$waybill.' '.iconv("cp1251", "utf-8", $row[3])."\n"); 
                                 #fwrite($fd, "Возврат по заказу $waybill добавлен в БД Курьер - ".'  '.iconv("cp1251", "utf-8", $row[3])."\n"); 
                                  }
                 
              else {
                    print_r("НЕТ Записи".' ' .$waybill[$i].' '.iconv("cp1251", "utf-8", $row[3])."\n");
                    fwrite($f_d, "Возврат по заказу $waybill[$i] добавлен в БД Курьер - ".'  '.iconv("cp1251", "utf-8", $row[3])."\n");
                     $result1=mysqli_query($link, "Insert into `returns` values(DEFAULT,'$row[1]', '$row[0]', '0', '1','$row[2]', '1', '0', '0', '$base_date[$i]', '$date_time[$i]','$row[2]','0',' ','RT', 'F','5', NULL , '0', '1', NULL , '0','0');"); 

                   }    
                               
            }
                 $index++;            
        }

   fclose($f_d);         

     ?>
   
