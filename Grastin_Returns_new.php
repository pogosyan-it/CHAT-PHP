<?php        

  $DateOfRequest5 ='return_list_'. $date_now.'.txt';
  $fd = fopen("/var/www/files/DOCK_reports/Grastin/P_Return/Returns/$DateOfRequest5",'a+') or die("не удалось создать файл");
  include 'courier2008.php';
  $index=0;
  $index1=0;

           $result = mysqli_query($link,  "select boxes.Code, boxes.address, boxes.Price, boxes.Name from boxes 
                                          left join address on address.code = boxes.address
                                          where address.client_id='$waybill[$i]';");
                                      
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                                $res=mysqli_query($link, "select COUNT(Box) from `returns` 
                                                          left join boxes on boxes.code = `returns`.Box where boxes.address='$row[1]';");
                              
                                while ($row1 = mysqli_fetch_array($res, MYSQL_NUM))   
                                {  
                                      
                                    $num=$row1[0];
                                    
  
                                    $index1++;
                                } 

                       $index++;       
                  }  


          if ($num==0)
 
      {    
  
           $result = mysqli_query($link,  "select boxes.Code, boxes.address, boxes.Price, boxes.Name from boxes 
                                           left join address on address.code = boxes.address
                                           where address.client_id='$waybill[$i]';");
                                      
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
 
                     $res=mysqli_query($link, "select COUNT(Box) from `returns` 
                                               left join boxes on boxes.code = `returns`.Box where boxes.address='$row[1]';");
                              
                                while ($row1 = mysqli_fetch_array($res, MYSQL_NUM))   
                                {  
                                      
                                    fwrite($fd, "Возврат по заказу $waybill[$i] добавлен в БД Курьер - ".'  '.iconv("cp1251", "utf-8", $row[3])."\n");
                                    print_r(iconv("cp1251", "utf-8", $row[3])."\n");
                                    $result1=mysqli_query($link, "Insert into `returns` values(DEFAULT,'$row[1]', '$row[0]', '0', '1','$row[2]', '1', '0', '0', '$base_date[$i]', '$date_time[$i]','$row[2]','0',' ','RT', 'F','5', NULL , '0', '1', NULL , '0','0');");
                                  
                                    $index1++;
                                } 

                       $index++;       
                  }         
        }
         
          fclose($fd);
          
     ?>
   
