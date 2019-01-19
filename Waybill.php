<html>    <title>Сканирование и закрытие накладной</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
 <style type="text/css">
   table {
          margin: auto; /* Выравниваем таблицу по центру окна  */
      border-collapse: collapse;
   }
     
 .my_button {
    width: 190px;
    height: 30px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}
.my_button1 {
    width: 200px;
    height: 35px;
border-radius: 10px; box-shadow: 0px 0px 5px; font-size: 16px
}
 </style>
 </head>
<body>
 <br/>  
<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center" >Сканирование и закрытие накладной</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['Waybill']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['Waybill'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'profilaktika.php'; 
     include 'gsotldb.php'; 
  ?>  
<table border=2px>

  <form name="MyForm" method="post">  
   
 <td><label for="WaybillNum"><center><font size="4" color="black"><b>Номер накладной:</b</font></label> 
                    <center><input type="text" name="WaybillNum" autofocus size="20"></td>

    </table>
    
<?php
echo "<br/>";
  echo "<center><font size='4' color='blue'>Процесс может занять длительное время</font>"; 		
   echo "<br/>";
   echo "<br/>";
echo "<center><button type='submit' formaction='Waybill.php' class='my_button'>Вывод результата</button>"; 
       echo "</center>";   
echo "<br/>";
  
 ?> 
 
    
 

<?php  
  if ($_SERVER['REQUEST_METHOD'] == "POST")  {
  /*$pattern="/^[0-9]+$/i";
  $waybill=$_POST['WaybillNum'];
  $found = (preg_match($pattern,$waybill));
  if ($found) {echo "TRUE";}
  else 
  {echo "FALSE";}  */
   $index=0;
  $waybill=$_POST['WaybillNum'];
  if(!empty($waybill)) {
  
  $res =  mysqli_query($link, "select WarehousID, SY_Void from d15_departures where d15_departures.WayBillNum = '$waybill';");  
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				   #printf($row['sName']);
				    $W_id=$row['WarehousID'];
            $void= $row['SY_Void'];
                }
        if (@$void=="" && @$W_id=="") { $nonaklbase='Накладной '.$waybill.' нет в базе';}
        elseif ($W_id==0 && $void==0) { $nonaklbase='Накладная '.$waybill.' не принята';}
        elseif ($W_id==0 && $void==1) { $nonaklbase='Накладная '.$waybill.' не принята и удалена';}
        elseif ($W_id==1 && $void==1) { $nonaklbase='Накладная '.$waybill.' принята и удалена';
        }
       

       
   else {
         $res =  mysqli_query($link, "SELECT d56vo2departure.SY_LastEdit, d56vo2departure.SY_Empl, hb_employee.SName
                                      FROM d56vo2departure left join hb_employee on d56vo2departure.SY_Empl=hb_employee.ID 
                                      left join d15_departures on d56vo2departure.d15ID=d15_departures.ID
                                      WHERE d15_departures.WayBillNum='$waybill' AND d15_departures.SY_Void = 0 
                                      AND d15_departures.WarehousID > 0 ORDER BY d56vo2departure.SY_Adding ASC Limit 1;");  
                                      while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				  
				                      $l_edit=$row['SY_LastEdit']; 
                              $empl_id=$row['SY_Empl']; 
                              $sname=$row['SName']; 
                              
                }
                              $empl_pr=@$empl_id.'@%';               
                            #  echo @$l_edit,@$empl_id; 
                
  if (@$l_edit=="" && @$empl_id=="" && @$sname=="")      
  
                 {
                         
                                      $res =  mysqli_query($link, "select count(1) as num from log_edit 
                                      left join d15_departures on d15_departures.ID=log_edit.FieldID 
                                      where d15_departures.SY_Void = 0 
                                      AND d15_departures.WarehousID > 0 and d15_departures.WayBillNum = '$waybill' and log_edit.TablID=15;");  
                                      while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                                          {
				  
				                                        $num=$row['num'];   
                                           }
  #echo $num; 
  
           if ( $num ==0 )
                            {
                            
                             $res =  mysqli_query($link, "SELECT d15_departures.SY_Adding, d15_departures.SY_Empl, hb_employee.SName
                                                          FROM d15_departures left join hb_employee on d15_departures.SY_Empl=hb_employee.ID 
                                                          WHERE d15_departures.WayBillNum='$waybill' AND d15_departures.SY_Void = 0 AND d15_departures.WarehousID>0");
                                       while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                                $l_edit=$row['SY_Adding'];
                                        $sname=$row['SName'];
                                        $empl_id=$row['SY_Empl'];
                            
                              }  
                                         $empl_id=@$empl_id.'@%';                    
							
              $res =  mysqli_query($link, "SELECT syEvents.conID from syEvents
                                           where syEvents.LogText like '$empl_id' and syEvents.syAdding < '$l_edit' order 
                                           by syEvents.syAdding DESC Limit 1 INTO @conID;");
              $res =  mysqli_query($link, "SELECT syEvents.LogText from syEvents where syEvents.UIN = @conID;");  							
							
                             while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                               $LogText=$row['LogText']; 
                            
                              } 
                                     /* echo "Блок_Первый_случай";
                                      echo "Номер накладной: - $waybill";
                                      echo "</br>";
                                      echo "Дата Сканирования: - $l_edit";
                                      echo "</br>";
                                      echo "ФИО: - $sname";
                                      echo "</br>";
                                      echo "IP: - $LogText";    */  
                            }
              elseif ( $num == 1)      {
              
                                        $res =  mysqli_query($link, "SELECT  d15_departures.SY_LastEdit, hb_employee.SName, syEvents.LogText
                                                                    FROM d15_departures 
                                                                    left join log_edit on log_edit.FieldID=d15_departures.ID 
                                                                    left join hb_employee on log_edit.SY_MembID=hb_employee.ID 
                                                                    left join syEvents on log_edit.syConnUIN=syEvents.UIN
                                                                    WHERE d15_departures.WayBillNum = '$waybill' AND d15_departures.SY_Void = 0 
                                                                    AND d15_departures.WarehousID > 0;");
              
                                             while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                                                  $LogText=$row['LogText']; 
                                                          $l_edit=$row['SY_LastEdit'];
                                                          $sname= $row['SName'];
                              }
                                              /*    echo "Блок_Второй_Случай";
                                                  echo "Номер накладной: - $waybill";
                                                  echo "</br>";
                                                  echo "Дата Сканирования: - $l_edit";
                                                  echo "</br>";
                                                  echo "ФИО: - $sname";
                                                  echo "</br>";
                                                  echo "IP: - $LogText";    */
              
              
                                        }     
                                           else 
                                           
                                           {
                                               $res =  mysqli_query($link, "SELECT d15_departures.ID, log_edit.ID
                                                                            FROM d15_departures 
                                                                            left join log_edit on log_edit.FieldID=d15_departures.ID 
                                                                            left join hb_employee on log_edit.SY_MembID=hb_employee.ID 
                                                                            left join syEvents on log_edit.syConnUIN=syEvents.UIN
                                                                            WHERE d15_departures.WayBillNum ='$waybill' AND d15_departures.SY_Void < 1 AND 
                                                                            log_edit.TablID=15 AND log_edit.lValues like '%::WarehousID==%' INTO @id1, @id2;");
                                              $res =  mysqli_query($link, "SELECT count(1) as num
                                                                           FROM log_edit WHERE log_edit.FieldID = @id1 AND log_edit.TablID = 15 AND log_edit.ID > @id2;");                              
                                                                            
                                           
                                           
                                                                       
                                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                                                  $num=$row['num']; 
                                                         
                              }
                        if ($num>0) 
                                     {
                                      $res =  mysqli_query($link, "SELECT d15_departures.ID, log_edit.ID
                                                                   FROM d15_departures 
                                                                   left join log_edit on log_edit.FieldID=d15_departures.ID 
                                                                   left join hb_employee on log_edit.SY_MembID=hb_employee.ID 
                                                                   left join syEvents on log_edit.syConnUIN=syEvents.UIN
                                                                   WHERE d15_departures.WayBillNum = '$waybill' AND d15_departures.SY_Void < 1 
                                                                   AND log_edit.TablID=15 AND log_edit.lValues like '%::WarehousID==%' INTO @id1, @id2");
                                                              
                                     $res =  mysqli_query($link, "SELECT hb_employee.SName, syEvents.LogText
                                                                   FROM d15_departures 
                                                                   left join log_edit on log_edit.FieldID=d15_departures.ID 
                                                                   left join hb_employee on log_edit.SY_MembID=hb_employee.ID 
                                                                   left join syEvents on log_edit.syConnUIN=syEvents.UIN
                                                                   WHERE d15_departures.WayBillNum = '$waybill' AND d15_departures.SY_Void < 1 
                                                                   AND log_edit.TablID=15 AND log_edit.lValues like '%::WarehousID==%'");   
                                                      while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                                                  $sname=$row['SName'];
                                                          $LogText=$row['LogText']; 
                                                         
                              }                                         
                                     $res =  mysqli_query($link, "SELECT SY_Edit
                                                                  FROM log_edit WHERE log_edit.FieldID = @id1 AND log_edit.TablID = 15 
                                                                  AND log_edit.ID > @id2 limit 1;"); 
                                                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                                                  $l_edit=$row['SY_Edit'];
                                                        
                                                         
                              }                          
                                                     /*     echo "Блок_3";
                                                          echo "Номер накладной: - $waybill";
                                                          echo "</br>";
                                                          echo "Дата Сканирования: - $l_edit";
                                                          echo "</br>";
                                                          echo "ФИО: - $sname";
                                                          echo "</br>";
                                                          echo "IP: - $LogText";     */
                        
                                     }
                else {
                
                        
                        
                        $res =  mysqli_query($link, "SELECT hb_employee.SName, syEvents.LogText
                                                     FROM d15_departures 
                                                     left join log_edit on log_edit.FieldID=d15_departures.ID 
                                                     left join hb_employee on log_edit.SY_MembID=hb_employee.ID 
                                                     left join syEvents on log_edit.syConnUIN=syEvents.UIN
                                                     WHERE d15_departures.WayBillNum='$waybill' AND d15_departures.SY_Void < 1 AND log_edit.TablID=15 
                                                     AND log_edit.lValues like '%::WarehousID==%'");
                                                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                                                  $sname=$row['SName'];
                                                          $LogText=$row['LogText']; 
                                                         
                              }                            
                        $res =  mysqli_query($link, "SELECT d15_departures.ID, log_edit.ID
                                                     FROM d15_departures 
                                                     left join log_edit on log_edit.FieldID=d15_departures.ID 
                                                     left join hb_employee on log_edit.SY_MembID=hb_employee.ID 
                                                     left join syEvents on log_edit.syConnUIN=syEvents.UIN
                                                     WHERE d15_departures.WayBillNum='$waybill' AND d15_departures.SY_Void < 1 AND log_edit.TablID=15 
                                                     AND log_edit.lValues like '%::WarehousID==%' INTO @id1, @id2");  
                        $res =  mysqli_query($link, "SELECT d15_departures.SY_LastEdit 
                                                     FROM log_edit 
                                                     left join d15_departures on d15_departures.ID=log_edit.FieldID 
                                                     WHERE log_edit.FieldID = @id1 AND log_edit.TablID = 15 AND log_edit.ID = @id2 limit 1;");   
                                                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                              {
				  
				                                                  $l_edit=$row['SY_LastEdit'];
                                            
                              }
                                                                                             
                                                     /*     echo "Блок_4";
                                                          echo "Номер накладной: - $waybill";
                                                          echo "</br>";
                                                          echo "Дата Сканирования: - $l_edit";
                                                          echo "</br>";
                                                          echo "ФИО: - $sname";
                                                          echo "</br>";
                                                          echo "IP: - $LogText";     */
                                                                                                            
                
                     }                             
        }
           }
        else 
                {
                                      $res =  mysqli_query($link, "SELECT syEvents.conID from syEvents
                                             where syEvents.LogText like '$empl_pr' and syEvents.syAdding < '$l_edit' order by syEvents.syAdding DESC Limit 1");  
                                      while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				  
				                               $con_id=$row['conID']; 
                            
                }
                                      $res =  mysqli_query($link, "SELECT syEvents.LogText from syEvents where syEvents.UIN ='$con_id';");  
                                      while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				  
				                               $LogText=$row['LogText']; 
                            
                }                                                  
                                    /*  echo "Блок_Разбор";
                                      echo "Номер накладной: - $waybill";
                                      echo "</br>";
                                      echo "Дата Сканирования: - $l_edit";
                                      echo "</br>";
                                      echo "ФИО: - $sname";
                                      echo "</br>";
                                      echo "IP: - $LogText";     */
                                      
                                           
                }
                  
                 }
                 
                 if (empty ($nonaklbase))
                 {
                   ?>
                 <TABLE  border=2px solid  ALIGN=center WIDTH=750px>

<tr>
<td  colspan="4"> 
<center><font size=5>Сканирование 
</td>
</tr>
<tr>
<td> 
    <b> <center>Номер накладной
   </td>
   <td>
 <b>  <center>Дата сканирования
      </td>
      <td>
  <b>   <center> ФИО
      </td>
      <td>
  <b> <center>   IP
      </td>    
   </tr>
    <td>
<center>   <?php  @print $waybill;?>
      </td>
      <td>
  <center>    <?php  @print $l_edit;?>
      </td>
      <td>
 <center>     <?php  @print $sname;?>
      </td>
      <td>
  <center>    <?php  @$ipScan = substr($LogText,5);
       @print $ipScan;?> 
      </td>
        </table>  <br/><br/>          
  <?php
  }
  else {  ?>
  <TABLE  border=2px solid  ALIGN=center WIDTH=750px>
<tr>
 <td  colspan="4"> 
<center> <font size=5>Сканирование 
</tr>
<tr>
<td  colspan="4"> 
<center>   <?php  @print "<font size='6' color='red'>$nonaklbase</font>"; ?> 
</td>
</tr> 
 </table>  <br/><br/>   
 <?php 
    
  }                 
 
                 $res =  mysqli_query($link, "SELECT d30_manifests.ManifestNum, d15_departures.WayBillNum, d30_manifests.CloseTS, hb_employee.SName, syEvents.LogText
                                 FROM d15_departures left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID
                                 left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID
                                left join log_edit on log_edit.FieldID=d30_manifests.ID
                                left join hb_employee on hb_employee.ID=log_edit.SY_MembID
                                left join syEvents on log_edit.syConnUIN=syEvents.UIN
                                WHERE d15_departures.WayBillNum = '$waybill' and log_edit.TablID=30 and log_edit.lValues like '%::fClose==%' and d30_manifests.fClose = 1 and d31_manifest2departure.SY_Void = 0 
                                or d15_departures.WayBillNum = '$waybill' and log_edit.TablID=30 and log_edit.lValues like '%::fClose==%' and d30_manifests.fClose = 1
                                and d31_manifest2departure.SY_Void = 1 and d30_manifests.CloseTS < d31_manifest2departure.SY_LastEdit;");
                                 while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                                 {  
                                                                              
                                                 $myresult_man[$index]=$row[0];
                                                 $myresult_way[$index]=$row[1];
                                                 $myresult_close[$index]=$row[2];
                                                 $myresult_SName[$index]=$row[3];
                                                 $myresult_Log[$index]=$row[4];
                                                 $index++; 
                                                                                                                                           
   ?>
     <TABLE  border=2px solid  ALIGN=center WIDTH=750px>
<tr>

<tr>
<td colspan="5"> 
<center><font size=5>Закрытие 
</td>
</tr>
<tr>
<td>
    <b> <center>Номер манифеста
   </td>
<td>
    <b> <center>Номер накладной
   </td>
   <td>
 <b>  <center>Дата закрытия
      </td>
      <td>
  <b>   <center> ФИО
      </td>
      <td>
  <b> <center>   IP
      </td>             
   </tr>
   <td>
<center>   <?php  @print ($row[0]);?>
      </td>
    <td>
 <center>  <?php  @print ($row[1]);?>
      </td>
      <td>
   <center>   <?php  @print ($row[2]);?>
      </td>
      <td>
   <center>   <?php  @print ($row[3]);?>
      </td>
      <td>
  <center>    <?php  @$ipClose = substr(($row[4]),5);
       @print $ipClose;?>  
      </td>
 
        </table><br/>  
    <?php                                                                                             
                                           }     
                                           if   ($index==0)
                                           {   $CloseNo='Накладная '.$waybill.' не закрыта';
                                                                                               
                                                   ?>
<TABLE  border=2px solid  ALIGN=center WIDTH=750px>
<tr>
 <td  colspan="5"> 
<center><font size=5>Закрытие 
</td>
</tr>
<tr>
<td colspan="5"> 
<center> <?php  @print "<font size='6' color='red'>$CloseNo</font>"; ?>
</tr>
</td>
</tr>
 </table>   <?php 
                                     }              
                                      }                
    
   
         else {echo "<font size='6' color='red'>Введите номер накладной</font>";}
     }

?>



 
</body>
</html>