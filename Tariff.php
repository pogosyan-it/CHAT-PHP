#!/usr/bin/php 

 <?php  

include 'gsotldb.php';

$index=0; 
                               
 $result = mysqli_query($link, "Select ROUND(d73TariffsValues.CashSumm/(1.2), 3), d73TariffsValues.UIN
                                 from d73TariffsValues where d73TariffsValues.UIN>'420';");   
                                    
                         while ($row2 = mysqli_fetch_array($result, MYSQL_NUM))
                          {
                         
                          $result1 = mysqli_query($link, "Update d73TariffsValues SET d73TariffsValues.BaseSumm='$row2[0]' where d73TariffsValues.UIN='$row2[1]'");   
                          $index++;
                         }              
                               
                                                                                          
                              
 ?>

