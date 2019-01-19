#!/usr/bin/php 

 <?php  

include 'gsotldb.php';
$index=0;
    $result = mysqli_query($link,  "Select d15_departures.WayBillNum from d15_departures 
                                      left join hbc_divAddr on hbc_divAddr.ID=d15_departures.ToDivID
                                      left join d11_addrs on d11_addrs.ID=d15_departures.R_AddrID
                                      left join d81_client2addr on d81_client2addr.ID=d15_departures.R_d81ID
                                      where d15_departures.WarehousID=2 and d11_addrs.Addr<>hbc_divAddr.Addr;");
                                      
                  while ($row = mysqli_fetch_array($result, MYSQL_NUM)) 
                  {
                     
                     $res=mysqli_query($link,   "update d15_departures
                                                  left join hbc_divAddr on hbc_divAddr.ID=d15_departures.ToDivID
                                                  set d15_departures.R_AddrID=hbc_divAddr.AddrID, d15_departures.R_d81ID=hbc_divAddr.d81ID
                                                  where d15_departures.WayBillNum = '$row[0]';");                           
                 
                                                         
                       $index++;
                  }     
                          
                          
                                               
                              
 ?>

