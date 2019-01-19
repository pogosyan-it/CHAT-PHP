<html>    <title>Операции с накладной</title>
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
    width: 380px;
    height: 40px;
border-radius: 10px; box-shadow: 0px 0px 5px; font-size: 16px
}
 </style>
 </head>
<body>
 <br/>  
<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form><form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 

<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['waybill']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['waybill'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'profilaktika.php'; 
     include 'gsotldb.php'; 
  ?>  
<table>
  <form name="MyForm" method="post">     
 <tr><td><input type="submit" name="submit1" class="my_button1" value="Разбор, сканирование, закрытие накладной" />
</td>

  <form action="testsb.php" method="post">
  <td> <label for="WaybillNum"><center><font size="4" color="black"><b>Номер накладной:</b</font></label> 
                    <center><input type="text" name="WaybillNum" autofocus size="20">    </td>
  <td>  <input type="submit" name="submit2" class="my_button1" value="Добавление и удаление накладной в манифесте" />   </td>
</form> </tr>
</table> 
<?php
echo "<br/>";
  echo "<center><font size='4' color='blue'>Процесс может занять длительное время</font>"; 		
   echo "<br/>";
   echo "<br/>";

  $waybill=$_POST['WaybillNum'];
  if(!empty($waybill)) {                 
  
  $res =  mysqli_query($link, "select WarehousID, SY_Void from d15_departures where d15_departures.WayBillNum = '$waybill';");  
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {
				   #printf($row['sName']);
				    $W_id=$row['WarehousID'];
            $void= $row['SY_Void'];
                }
        if (@$void=="" && @$W_id=="") { echo "<h3 style=\"color:red;\">Накладной $waybill нет в базе</h3>"; exit;}
        elseif ($W_id==0 && $void==0) { echo "<h3 style=\"color:red;\">Накладная $waybill не принята</h3>"; exit;}
 else {     
   if (isset($_POST['submit1'])) { 
           //Разбор
      $index=0; 
         $res =  mysqli_query($link, "SELECT b.Name as sender , a.Name as reciver, d56vo2departure.SY_LastEdit, hb_employee.SName, 
                                      d15_departures.SY_Void, d56vo2departure.SY_Empl				
                                      FROM d56vo2departure				
                                      left join hb_employee on d56vo2departure.SY_Empl=hb_employee.ID				
                                      left join d15_departures on d56vo2departure.d15ID=d15_departures.ID				
                                      left join hbc_divisions a on d15_departures.ToDivID=a.ID				
                                      left join hbc_divisions b on d15_departures.FromDivID=b.ID				
                                      WHERE d15_departures.WayBillNum='$waybill' 				
                                      AND d15_departures.WarehousID > 0 ORDER BY d56vo2departure.SY_Adding;");  
                   $ruz_num=mysqli_num_rows($res);
                   #echo $n;
                   if   ($ruz_num==0) {echo "<h4 style=\"color:green;\">Разбора не было</h4>";}
                   else{
                            ?>  
                                     <body>
                                         <table border="1">
                                      <tr>
                                          <th colspan="7">Разбор накладной</th>
                                      </tr>
                                        <tr>
                                          <td>Удалена</td>
                                          <td>Номер Накладной</td>
                                          <td>Отправитель</td>
                                          <td>Получатель</td>
                                          <td>Дата Разбора</td>
                                          <td>ФИО</td>
                                          <td>IP</td>
                                       </tr>
                                     
                                 <?php
                                       
                            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
                              $index++; 
                               $empl_id=@$row[5].'@%'; 
                              $res1 =  mysqli_query($link, "SELECT syEvents.conID from syEvents		
                                           where syEvents.LogText like '$empl_id' and syEvents.syAdding < '$row[2]' order 		
                                           by syEvents.syAdding DESC Limit 1 INTO @conID;");		
                              $res1 =  mysqli_query($link, "SELECT syEvents.LogText from syEvents where syEvents.UIN = @conID;");  		
		
                             while ($row_new = mysqli_fetch_array($res1, MYSQLI_ASSOC)) 		
                              {		
                               #$LogText=$row_new['LogText']; 
                               @$ipScan = substr($row_new['LogText'],5);		
                              } 		

                             if ($row[4]==0) {
                             
                              ?>     <tr>
                                            <td>Нет</td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[0] ?></td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                       
                                             
                                 <?php             }
                           else   {
                                
                                 ?>     <tr>
                                            <td>Да</td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[0] ?></td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                       </tr>       
                                       
                                             
                                 <?php     }          
              
                }
                                  ?>    
                                        </table>
                                                
                                  <?php
                                 }     
      //сканирование                            
                
                $res =  mysqli_query($link, "SELECT d15_departures.SY_Void, b.Name, a.Name, log_edit.Created_Time, c.SName, 
                                              syEvents.LogText			
                                              FROM d15_departures			
                                              left join log_edit on log_edit.FieldID=d15_departures.ID			
                                              left join hb_employee on log_edit.SY_MembID=hb_employee.ID			
                                              left join hbc_divisions a on d15_departures.ToDivID=a.ID			
                                              left join hbc_divisions b on d15_departures.FromDivID=b.ID			
                                              left join hb_employee c on log_edit.SY_MembID=c.ID			
                                              left join syEvents on log_edit.syConnUIN=syEvents.UIN			
                                              WHERE d15_departures.WayBillNum='$waybill' and log_edit.TablID=15 
                                              and log_edit.lValues like '%::WarehousID==%';");  
                                              
                                              $scan_num=mysqli_num_rows($res);
                                            if ($scan_num==0) {echo "<h4 style=\"color:green;\">Не сканировалась</h4>";}
                                            else {
                                              
                            ?>  
                                     <body>
                                         <table border="1">
                                      <tr>
                                          <th colspan="7">Сканирование накладной</th>
                                      </tr>
                                        <tr>
                                          <td>Удалена</td>
                                          <td>Номер Накладной</td>
                                          <td>Отправитель</td>
                                          <td>Получатель</td>
                                          <td>Дата Сканирования</td>
                                          <td>ФИО</td>
                                          <td>IP</td>
                                       </tr>
                                     
                                 <?php
         $index=0;                              
                                      while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
                              $index++; 
                              $ipScan = substr($row[5],5);
 	                            if ($row[0]==0) {
                                     
                              ?>     <tr>
                                            <td>Нет</td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $row[4] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                       
                                             
                                 <?php             }
                           else   {
                                
                                 ?>     <tr>
                                            <td>Да</td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $row[4] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                             
                                 <?php     }          
              
                }
                                  ?>    
                                        </table>
                                        
                                  <?php
                           }      //Закрытие накладной 
                  
                $res =  mysqli_query($link, "SELECT d30_manifests.ManifestNum, b.Name, 
                                             a.Name, hb_employee.SName, d30_manifests.CloseTS, syEvents.LogText					
                                            FROM d15_departures left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID					
                                            left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID					
                                            left join log_edit on log_edit.FieldID=d30_manifests.ID					
                                            left join hb_employee on hb_employee.ID=log_edit.SY_MembID					
                                            left join hbc_divisions a on d15_departures.ToDivID=a.ID					
                                            left join hbc_divisions b on d15_departures.FromDivID=b.ID					
                                            left join syEvents on log_edit.syConnUIN=syEvents.UIN					
                                            WHERE d15_departures.WayBillNum = '$waybill' and log_edit.TablID=30 and log_edit.lValues like '%::fClose==%' 
                                            and d30_manifests.fClose = 1;");  
                                              
                                              $scan_num=mysqli_num_rows($res);
                                            if ($scan_num==0) {echo "<h4 style=\"color:green;\">Не закрывалась</h4>"; }
                                            else {
                                              
                            ?>  
                                     <body>
                                         <table border="1">
                                      <tr>
                                          <th colspan="7">Закрытие накладной</th>
                                      </tr>
                                        <tr>
                                          <td>Номер манифеста</td>
                                          <td>Номер Накладной</td>
                                          <td>Отправитель по накладной</td>
                                          <td>Получатель по накладной</td>
                                          <td>Кто закрывал</td>
                                          <td>Дата Закрытия</td>
                                          <td>IP</td>
                                       </tr>
                                     
                                 <?php
         $index=0;                              
                                      while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
                              $index++; 
                              $ipScan = substr($row[5],5);
 	                                                                 
                              ?>     <tr>
                                            <td><?php echo $row[0]?></td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $row[4] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                       
                                             
                                 <?php             
        
                }
                                  ?>    
                                        </table>
                                        
                                  <?php
                           }     
                                }                         
                                //Добавление накладной в манифест
                                   if (isset($_POST['submit2'])) { 
    
         $index=0; 
         $res =  mysqli_query($link, "select d30_manifests.ManifestNum, b.Name, a.Name, hb_employee.SName, d31_manifest2departure.SY_Adding, 
                                       hb_employee.ID, d31_manifest2departure.SY_Void					
                                      from d31_manifest2departure					
                                      left join d30_manifests on d30_manifests.ID = d31_manifest2departure.d30ID					
                                      left join d15_departures on d15_departures.ID = d31_manifest2departure.d15ID					
                                      left join hb_employee on hb_employee.ID = d31_manifest2departure.SY_Empl					
                                      left join hbc_divisions a on d15_departures.ToDivID=a.ID					
                                      left join hbc_divisions b on d15_departures.FromDivID=b.ID					
                                      where d15_departures.WayBillNum = '$waybill';");  
                   $ruz_num=mysqli_num_rows($res);
                   #echo $n;
                   if   ($ruz_num==0) {echo "<h4 style=\"color:green;\">Не добавлялась в манифест</h4>"; }
                   else{
                            ?>  
                                     <body>
                                         <table border="1">
                                      <tr>
                                          <th colspan="8">Добавление накладной в манифест</th>
                                      </tr>
                                        <tr>
                                          <td>Удаление</td>
                                          <td>Номер Манифеста</td>
                                          <td>Номер Накладной</td>
                                          <td>Отправитель по накладной</td>
                                          <td>Получатель по накладной</td>
                                          <td>Дата Добавления</td>
                                          <td>ФИО</td>
                                          <td>IP</td>
                                       </tr>
                         <?php
                                       
                            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
                              $index++; 
                               $empl_id=@$row[5].'@%'; 
                               $res2 =  mysqli_query($link, "SELECT syEvents.conID from syEvents		
                                           where syEvents.LogText like '$empl_id' and syEvents.syAdding < '$row[4]' order 		
                                           by syEvents.syAdding DESC Limit 1 INTO @conID;");		
                              $res2 =  mysqli_query($link, "SELECT syEvents.LogText from syEvents where syEvents.UIN = @conID;");  		
	                      
                           while ($row_new = mysqli_fetch_array($res2, MYSQLI_ASSOC)) 		
                              {		
                               #$LogText=$row_new['LogText']; 
                               @$ipScan = substr($row_new['LogText'],5);		
                              } 		
                               if ($row[6]==0) {
                              ?>     <tr>
                                            <td>В манифесте</td>
                                            <td><?php echo $row[0]?></td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[1] ?></td>
                                            <td><?php echo $row[2] ?> </td>
                                            <td><?php echo $row[4] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                       
                                             
                                 <?php                     
                                              }
                                 else {
                                         ?>     <tr>
                                            <td>Удалена</td>
                                            <td><?php echo $row[0]?></td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[1] ?></td>
                                            <td><?php echo $row[2] ?> </td>
                                            <td><?php echo $row[4] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                       
                                             
                                 <?php 
                                 
                                       }             
                }
                                  ?>    
                                        </table>
                                                
                                  <?php
                                 }    
                              
                                //Удаление накладной из манифеста                            
                   
                $res =  mysqli_query($link, "select d30_manifests.ManifestNum, b.Name, a.Name, 
                                            c.SName, log_edit.Created_Time, syEvents.LogText			
                                            from d31_manifest2departure			
                                            left join d30_manifests on d30_manifests.ID = d31_manifest2departure.d30ID			
                                            left join d15_departures on d15_departures.ID = d31_manifest2departure.d15ID			
                                            left join hb_employee on hb_employee.ID = d31_manifest2departure.SY_Empl			
                                            left join log_edit on log_edit.FieldID=d31_manifest2departure.ID			
                                            left join hbc_divisions a on d15_departures.ToDivID=a.ID			
                                            left join hbc_divisions b on d15_departures.FromDivID=b.ID			
                                            left join hb_employee c on log_edit.SY_MembID=c.ID			
                                            left join syEvents on log_edit.syConnUIN=syEvents.UIN			
                                            where d15_departures.WayBillNum = '$waybill' and d31_manifest2departure.SY_Void = '1';");  
                                              
                                              $scan_num=mysqli_num_rows($res);
                                            if ($scan_num==0) {echo "<h4 style=\"color:green;\">Не Удалялась из манифеста</h4>"; }
                                            else {
                                              
                            ?>  
                                     <body>
                                         <table border="1">
                                      <tr>
                                          <th colspan="7">Удаление накладной из манифеста</th>
                                      </tr>
                                        <tr>
                                          <td>Номер манифеста</td>
                                          <td>Номер Накладной</td>
                                          <td>Отправитель по накладной</td>
                                          <td>Получатель по накладной</td>
                                          <td>Кто Удалил</td>
                                          <td>Дата Удаления</td>
                                          <td>IP</td>
                                       </tr>
                                     
                                 <?php
         $index=0;                              
                                      while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
                              $index++; 
                              $ipScan = substr($row[5],5);
 	                                                                 
                              ?>     <tr>
                                            <td><?php echo $row[0]?></td>
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $row[4] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                       
                                             
                                 <?php             
        
                }
                                  ?>    
                                        </table>
                                        
                                  <?php
                           }                  
                             //Упаковка  накладной в манифест. {Время каждого пропикивания накладной в манифесте}
                          $res =  mysqli_query($link, "Select  d30_manifests.ManifestNum, hb_employee.SName,	log_edit.Created_Time,		
                                                      syEvents.LogText from d15_departures			
                                                      left join d31_manifest2departure on d31_manifest2departure.d15ID=d15_departures.ID			
                                                      left join d30_manifests on d30_manifests.ID=d31_manifest2departure.d30ID			
                                                      left join log_edit on log_edit.FieldID=d31_manifest2departure.ID			
                                                      left join hb_employee on hb_employee.ID=log_edit.SY_MembID			
                                                      left join syEvents on log_edit.syConnUIN=syEvents.UIN			
                                                      where d15_departures.WayBillNum='$waybill' and log_edit.lValues like '%ProcErr%' and log_edit.TablID=31	");  
                                              
                                               $scan_num=mysqli_num_rows($res);
                                            if ($scan_num==0) {echo "<h4 style=\"color:green;\">Не Закрывалась</h4>";}
                                            else {
                                              
                            ?>  
                                     <body>
                                         <table border="1">
                                      <tr>
                                          <th colspan="5">Упаковка  накладной в манифест.</th>
                                      </tr>
                                        <tr>
                                          <td>Номер закрытого места</td> 
                                          <td>Номер Накладной</td>
                                          <td>Номер Манифеста</td>
                                          <td>Кто Упаковывал</td>
                                          <td>Дата</td>
                                          <td>IP</td>
                                       </tr>
                                     
                                 <?php
         $index=0;                              
                                      while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
                              $index++; 
                              $ipScan = substr($row[3],5);
 	                                                                 
                              ?>     <tr>
                                            <td><?php echo $index ?></td>
                                            <td><?php echo $waybill ?></td>
                                            <td><?php echo $row[0]?> </td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                       
                                             
                                 <?php             
        
                }
                                  ?>    
                                        </table>
                                        
                                  <?php
                           }   
                                
                                } 
                         }   
                                }  
                                       
                                                else {echo "<h3 style=\"color:red;\">Введите номер накладной.</h3>";}
?>
     


 
</body>
</html>