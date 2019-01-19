<html>    <title>Создать ВП</title>
<head> <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">

 <style type="text/css">
   table {
    width: 550px; /* Ширина таблицы */
    margin: auto; /* Выравниваем таблицу по центру окна  */
   }
      td
 {
 border: 1px #336699 solid;  
 }
 .my_button {
    width: 170px;
    height: 30px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}
.my_button1 {
    width: 200px;
    height: 35px;
border-radius: 10px; box-shadow: 0px 0px 5px; font-size: 16px
}
 </style>
 
 <?php
 @ include 'TehRaboty.php';  
include 'profilaktika.php'; 
?>
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
   <h3><div align="center" >Создать внутреннюю почту</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['createVP3']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['createVP3'])){
     header("Location: Menu.php");
     exit;                    }  
       include 'gsotldb.php'; 
     $res = mysqli_query($link, "Select hb_employee.SName from hb_employee where hb_employee.login='$Login'");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
           {
						   $send=$row['SName'];
              
					   }  
 
 $_SESSION['send'] = $send;

if (isset($_SESSION['NoDest'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Не выбран регион назначения!</font></div>          
            <?php
  unset($_SESSION['NoDest']);   
 }
  else 
  {
  unset($_SESSION['NoDest']);
 }
    
 if (isset($_SESSION['NoWeight'])) 
  {
  ?>
<div id="error"><font size="6" color="red">Неверно указан вес!</font></div>          
            <?php 
  unset($_SESSION['NoWeight']);   
 }
  else 
  {
  unset($_SESSION['NoWeight']);
 }
 
 if (isset($_SESSION['NoPlaces'])) 
  {
  ?>
<div id="error"><font size="6" color="red">Неверно указано количество мест!</font></div>          
            <?php 
  unset($_SESSION['NoPlaces']);   
 }
  else 
  {
  unset($_SESSION['NoPlaces']);
 }
 
 if (isset($_SESSION['NoNum'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Номера закончились, заходите завтра!</font></div>          
            <?php
  unset($_SESSION['NoNum']);   
 }
  else 
  {
  unset($_SESSION['NoNum']);
 } 
 
 if (isset($_SESSION['NumThere'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Номер <?php print $_SESSION['NumThere'] ?> уже существует, попробуйте еще раз!</font></div>            
            <?php
  unset($_SESSION['NumThere']);   
 }
  else 
  {
  unset($_SESSION['NumThere']);
 } 
 
  if (isset($_SESSION['NoAddr'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Нет отправок в данном направлении!</font></div>          
            <?php
  unset($_SESSION['NoAddr']);   
 }
  else 
  {
  unset($_SESSION['NoAddr']);
 }       
         

?>  
    <form action="createVP4.php" method="post">  
    <table>
    <tr>
        <td align="right">Регион Отправления:</td>
        <td><font size="6"><b>CORP</b></td>
    </tr>
    <tr>
        <td align="right">Регион Назначения:</td>
        <td></select>
  <?php 
    
   echo "<form method='post' action=''>
      <select name='dest'>
      <option value=''>Выберите Регион Назначения</option>";     
	  
      
$res_pref =  mysqli_query($link, "SELECT Name, Mask from hbc_divAddr where hbc_divAddr.AddrID not in ('0') order by Name") ;                 
 
while ($row = mysqli_fetch_assoc($res_pref)){

echo "<option value='".$row['Name']."'>".$row['Name']." (".$row['Mask'].")</option>";
 
}


   ?>
      <tr>
        <td align="right">Отправитель:</td>
        <td><p><textarea disabled placeholder="<?php print$send;?>" maxlength="60" rows="1" cols="45" name="sender"></textarea></p></td>
    </tr>
       </select><br/></td>
    </tr>
    <tr>
        <td align="right">Получатель:</td>
       <td><p><textarea placeholder="ССС" maxlength="20" rows="1" cols="45" name="FIO"></textarea></p></td>
    </tr>
    <tr>
        <td align="right">Кол-во мест:</td>
         <td><p><textarea placeholder="1" maxlength="5" rows="1" cols="45" name="places"></textarea></p></td>
     </tr>
     <tr>
        <td align="right">Вес:</td>
        <td><p><textarea  placeholder="0,5" maxlength="5" rows="1" cols="45" name="weight"></textarea></p></td>
    </tr>    
    <tr>
        <td align="right">Описание груза:</td>
        <td><p><textarea  maxlength="250" rows="3" cols="45" name="discr"></textarea></p></td>
    </tr>
    <tr>
        <td align="right">Спец. Инструкции:</td>
        <td>
        <p><textarea  maxlength="50" rows="1" cols="45" name="instruct"></textarea></p>
        </td>
        <tr>        
        <td align="right">Эконом:</td>
        <td><p><input type="checkbox" name="tipe" value="Yes" /></p></td>
    </tr>
   
 
                     
           
               
    <tr>    <td>       </td>
                 
   <td><input type="submit" name="run" value="Создать" class="my_button"></td> </tr>
    </form> 
    </table>
 
</body>
</html>