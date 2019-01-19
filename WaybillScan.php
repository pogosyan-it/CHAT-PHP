<html>    <title>Список принятых накладных выбранным сотрудником за определенный период</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css"> 
 <link rel="stylesheet" href="tcal.css">  
 <style type="text/css">
   table {
    width: 300px; /* Ширина таблицы */
    margin: auto; /* Выравниваем таблицу по центру окна  */
    border-collapse: collapse;
   }
         td
 {
border: 1px solid #000; 
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
   <h3><div align="center" >Принятые накладные выбранным сотрудником</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['WaybillScan']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['WaybillScan'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'profilaktika.php'; 
     include 'gsotldb.php'; 
     
     if (isset($_SESSION['noreg'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Не выбран регион отправления!</font></div>          
            <?php
  unset($_SESSION['noreg']);   
 }
  else 
  {
  unset($_SESSION['noreg']);
 } 
 
    if (isset($_SESSION['noempl'])) 
  {   
  ?>     
  <div id="error"><font size="6" color="red">Не выбран Сотрудник!</font></div>          
            <?php
  unset($_SESSION['noempl']);   
 }
  else 
  {
  unset($_SESSION['noempl']);
 }
     
   
    if (isset($_SESSION['noconect'])) 
  { 
  ?>
<div id="error"><font size="6" color="red"><?php print $_SESSION['noconect'] ?> не заходил в GSoT <?php print $_SESSION['time_from'] ?></font></div>          
            <?php
  unset($_SESSION['noconect']);   
 }
  else 
  {
  unset($_SESSION['noconect']);
 } 

 
  if (isset($_SESSION['nodestination'])) 
  { 
  ?>
<div id="error"><font size="6" color="red"><?php print $_SESSION['user'] ?> не принимал накладные из <?php print $_SESSION['nodestination']?> <?php print $_SESSION['time_from'] ?></font></div>          
            <?php
  unset($_SESSION['nodestination']);   
 }
  else 
  {
  unset($_SESSION['nodestination']);
 } 
 
 ?>
 
<br/>
<table>
    <tr>
                <center><form name="MyForm" method="post">
        <td>

      <script type="text/javascript" src="tcal.js"></script> 
      <div><input type="text" name="date" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите дату" /></div>      
            </td>
                  <td> 
      <label for="hour"><center>Время:</label><br/>  
       <select name="hour">
       <option value="16:00:00">с 16:00 до 01:00</option>
       <option value="01:00:00">с 01:00 до 16:00</option>
    </td>
    <td>
      
       <?php 
        
   echo "<center>Отправитель";
   echo "<br/>"; 
   echo "<br/><center><form method='post' action=''>
      <select name='region'>
      <option value=''> Выберете регион отправителя </option>";   
	                                               
$res_pref =  mysqli_query($link, "Select hbc_divisions.Name from hbc_divisions");                 
 
while ($row = mysqli_fetch_assoc($res_pref)){

echo "<option value='".$row['Name']."'>".$row['Name']." </option>";
                                                 } 
?>
   </td>
    
    <td>
      
       <?php 
   
  echo "<center>Принимающий";
   echo "<br/>"; 
   echo "<br/><center><form method='post' action=''>
      <select name='sname'>
      <option value=''> Выберете сотрудника </option>";   
	                                               
$res_pref =  mysqli_query($link, "Select hb_employee.SName from hb_employee where hb_employee.DepartamentID in ('2','6','9','14','15','18') 
                                  and hb_employee.SY_Void='0' and hb_employee.fUser='1' and hb_employee.SName not in ('DIMEX - УК ....', 'UK L.0.', '') or hb_employee.ID='23' order by SName;");                 
 
while ($row = mysqli_fetch_assoc($res_pref)){

echo "<option value='".$row['SName']."'>".$row['SName']." </option>";
                                                 } 

?>
   </td>
    </tr>
    <tr> 
          
    </tr>
    <tr>

    </td>
     <td colspan="4"> 
<?php 		
   echo "<br/>";

      echo "<center><p><button type='submit' formaction='Examples\waybillexcel.php' class='my_button'>Вывод списка в Excel</button></p>"; 
echo "</form></center>"; 
echo "<br/>";
  echo "<center><font size='4' color='blue'>Процесс может занять длительное время</font>"
 ?> 
      </td>
    </tr>
</table>
   
<?php  
#  if ($_SERVER['REQUEST_METHOD'] == "POST")  {
 #   }
    
?>


</body>
</html>