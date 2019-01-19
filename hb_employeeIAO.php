<html>  <title>Операторы БД</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="chekbox.css"  type="text/css"> 
 <link rel="stylesheet" href="tcal.css">  
 <style type="text/css">  
 body{ text-align: center;  background-image: url(yellow-specks.png);}
.my_button {
    width: 190px;
    height: 40px;
border-radius: 55px; box-shadow: 1px 1px 3px; font-size: 16px }
  </style> 
 <?php  
 $sum=0;
include 'profilaktika.php'; 
?>
 </head>
<body>

<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form>      
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center">Операторы БД</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['hb_employeeIAO']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['hb_employeeIAO'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'gsotldb.php';
    ?>              
        <table  align=center text-align=left  >
        <tr>
           <td valign="top"; align="right"> <table border=2px  text-align=left  > <td><center><b>ФИО</b></td>          <td><center><b>Количество</b></td>
<?php 
if ($_POST['time_from']=='Время'){$time_from='16:00:00';} else {$time_from = $_POST['time_from'].':00:00';}
if ($_POST['time_by']=='Время'){$time_by='15:59:59';} else {$time_by = $_POST['time_by'].':00:00';}
if ($time_by==24){$time_by='23:59:59';} 
if ($_POST['date_by'] =='или интервал') {$date_by1='2020-02-08';}   else {$date_by1=$_POST['date_by'];}
if ($_POST['date_from'] =='выберите один день' or strtotime($_POST['date_from']) > strtotime($date_by1)) {$date_from='не выбрана дата';}
else {
if (@$_POST['stat']) {  
$date_from = $_POST['date_from'].' '.$time_from;
if ($_POST['date_by'] =='или интервал' or  $_POST['date_from'] == $_POST['date_by'] ) 
{$date= $_POST['date_from']; $d = new DateTime($date); $d->modify("+1 day"); $date_by=$d->format("Y-m-d").' '.$time_by; }
else {$date_by=$_POST['date_by'].' '.$time_by;   } 

 $index0=0; 
$res0 =  mysqli_query($link, "Select hb_employee.ID  from hb_employee left join hb_employeeIAO on hb_employee.ID=hb_employeeIAO.emp_id where hb_employeeIAO.emp_id=hb_employee.ID"); 
  while ($row0 = mysqli_fetch_array($res0, MYSQLI_NUM))   
   {   
  $membid .= $row0[0].','; 
  $index1++; 
      }
       $membid= rtrim($membid, ',');

  $res2 =  mysqli_query($link, "SELECT hb_employee.SName, COUNT(distinct d15_departures.WayBillNum) FROM d15_departures 
                                left join log_edit on log_edit.FieldID=d15_departures.ID
                                left join hb_employee on log_edit.SY_MembID=hb_employee.ID
                                WHERE  
                                log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%_%ID%'
                                or
                                log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%_Name%'
                                or
                               log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%_Contact%'
                                or
                                log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%_Phone%'
                                or
                                  log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%_Addr%'
                                or
                                  log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%Discr%'
                                or
                                 log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%world%'
                                or
                                 log_edit.SY_MembID in ($membid)
                                and log_edit.Created_Time between '$date_from' and '$date_by' and log_edit.TablID=15 
                                and log_edit.lValues like '%Pay%' 
                                group by hb_employee.SName"); 
  while ($row1 = mysqli_fetch_array($res2, MYSQLI_NUM))   
   {     

 $sum=$sum +$row1[1];
 ?>   <tr>   <td valign="top"; align="right">
  <?php echo $row1[0] ?> </td>
   <td valign="top"; align="right">
  <?php echo $row1[1] ?> </td>
   </tr>       <?php  $index0++; }   
                   
 ?><td valign="top"; align="right">  <?php echo "<h3 style=\"color:;\">Сумма</h3>";  ?>  </td>
 <td valign="top"; align="right">  <?php echo "<h3 style=\"color:;\">$sum</h3>";  ?>  </td> <?php 
 }
  }                              
?> </table>  </td> 
           <td valign="top">
 <table border=2px  text-align=center  >
 
    <tr>  <td>                                          
     <?php 
echo "<center><b>ФИО</b>";
echo "<center><form method='post' action=''>
      <select name='ID'>  
      <option value=''> Выберите сотрудника </option>";   
	                                               
$res_pref =  mysqli_query($link, "select ID, SName
            from hb_employee 
            where hb_employee.fUser = '0' and hb_employee.PostID not in (20,0) and 
            hb_employee.ID not in (4192,1415,1560,1737,1237,1239,1240,1241,1521,1242,1243,1238,1244,233,733,232,234,235,498,499,1509,1510,3784,1015,1739,1738,571)
            and hb_employee.ID not in (Select hb_employeeIAO.emp_id from hb_employeeIAO) or 
            hb_employee.fUser = '1' and  hb_employee.DepartamentID not in (11) and hb_employee.ID not in (3877,3568,3706,3708,3709,3710,3711,3712) and 
            hb_employee.ID not in (Select hb_employeeIAO.emp_id from hb_employeeIAO) ORDER BY hb_employee.LName");                 
while ($row = mysqli_fetch_assoc($res_pref)){            
echo "<option value='".$row['ID'].")".$row['SName']."'>".$row['SName']." </option>";
                                            }          
 ?>  </td>   <tr>  <td> 
     <form method='post'>  
<center><br /> <input type="submit" name="run" value='Добавить' class="my_button">  
 <br /> </form> 
   <br />   </td>  </tr>    
                                                     <td>                                                     
                                                     <center><b>Для подсчёта одного дня <br /> достаточно указать его в первом календаре</b>
          <br />
<script type="text/javascript" src="tcal.js"></script> 
      <form action="hb_employeeIAO.php" method="post">
		<div><input type="text" name="date_from" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите один день" /><select name="time_from">
        <option value="Время">16:00</option>
        <option value="00">00</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>   
        <option value="23">23</option>      
         </select></div><br />   
    <div><input type="text" name="date_by" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="или интервал" /><select name="time_by">
       <option value="Время">15:59</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>   
        <option value="23">23</option> 
        <option value="24">24</option>  
       </select></div>   
  <br />    
      <input type="submit" name="stat" value='Посчитать' class="my_button">  
         </form> 
           <font color="blue" size="4">Подсчёт может занять до 2-x минут!</font>
  </td>  </tr> 
<tr>           
  <td>  
 <?php
 echo "<center><h3 style=\"color:black;\">Выбранный интервал:</h3>"; 
   echo "<h3 style=\"color:green;\">$date_from</h3>"; 
  # if  ($date_from!=='не выбрана дата') {echo "<h3 style=\"color:green;\">по</h3>"; }
    echo "<h3 style=\"color:green;\">$date_by</h3>"; 
 if (isset($_SESSION['addemplIAO']))   {
 echo @$_SESSION['addemplIAO'];
?>   <?php
 unset($_SESSION['addemplIAO']); }
?> </td>
</tr> </table> </td>  
    <?php 
$index=0; 
$res =  mysqli_query($link, "select hb_employee.SName
from hb_employeeIAO
left join hb_employee on hb_employee.ID=hb_employeeIAO.emp_id ORDER BY hb_employee.SName");
                      ?>  <td valign="top"> <table border=1px   >
                                        <tr>  <td><center><b>ФИО</b></td>
                                              <td><center><b>Удаление</b></td>                                            
                                        </tr> 
                                        <form method='post'>   
<?php    
  while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
             $index++;                                                                                                                        
                                           ?> <tr>    <td>   <?php echo $row[0] ?> </td>
   <td><input type="checkbox" class="checkbox" id="<?php echo $row[0] ?>" name="chb[]" value="<?php echo $row[0] ?>" /> <label for="<?php echo $row[0] ?>">  </label> </td>                                             
                                                                                                                                  
                                 <?php  
                                   if(isset($_POST['submit']))
{     
     foreach ($_POST['chb'] as $value)
         switch ($value) {
             case "$row[0]":
/*Action1 */ 
             $res1 =  mysqli_query($link, "delete hb_employeeIAO from hb_employeeIAO left join hb_employee on hb_employee.ID=hb_employeeIAO.emp_id where hb_employee.SName='$row[0]'");
             
             break;  
         } 
      print'<meta http-equiv="refresh" content="0;hb_employeeIAO.php">';       
}                    
    ?>    </tr>        <?php                        
               }  
           ?>   
<td colspan=3><center> <input type='submit' name="submit" value='Удалить отмеченных' class="my_button">          </form></td>          </table>     </td>
 
         <?php
 $IDS=explode(")", @$_POST['ID']);
 $ID=$IDS[0]; 
 $SName=$IDS[1];

 if (@$_POST['run']) { 
 if  (empty ($ID) ) {$_SESSION['addemplIAO']= "<h3 style=\"color:red;\">Не выбран сотрудник</h3>";
 print'<meta http-equiv="refresh" content="0;hb_employeeIAO.php">'; }
 else {
$view_db = mysqli_query($link, "Select * from hb_employeeIAO where emp_id='$ID'"); 
    $row_num = mysqli_num_rows($view_db);
/*Action2 */         
 if   ($row_num==0) {    $resul =  mysqli_query($link, "Insert into hb_employeeIAO VALUES(DEFAULT, '$ID' )"); 
 if (mysqli_affected_rows($link)==1) {
    $_SESSION['addemplIAO'] = "<h4 style=\"color:green;\">\"$SName\" добавлен</h4>";  
  print'<meta http-equiv="refresh" content="0;hb_employeeIAO.php">';      
                                     }
 else {echo "Ошибка при добавлении";}     
                    }                  
      }                 }        
     
  ?>
 </tr>
 </table>     

</body>
</html>
