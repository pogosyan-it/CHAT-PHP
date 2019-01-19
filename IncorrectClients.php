<html>  <title>Некорректные организации</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylephp.css"  type="text/css">
  <link rel="stylesheet" href="tcal.css"> 
 <style type="text/css">
 td
 {
 border: 1px #336699 solid;
 }
.my_button {
    width: 220px;
    height: 40px;
border-radius: 55px; box-shadow: 1px 1px 3px; font-size: 15px
}
 </style>
 <?php  
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
   <h3><div align="center" >Некорректные организации</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['IncorrectClients']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['IncorrectClients'])){
     header("Location: Menu.php");
     exit;                    }  
   
 include 'gsotldb.php';
 
  if (isset($_SESSION['nodate'])) 
  { 
  ?>
<div id="errorchl"><font size="6" color="red">Не выбрана дата!</font></div>          
            <?php
  unset($_SESSION['nodate']);   
 }
  else 
  {
  unset($_SESSION['nodate']);
 }
 
?>    
<br/>
<script type="text/javascript" src="tcal.js"></script> 
 <p><font size="5">Выберите с какой даты выбрать данные</font></p>
  
 <center><form action="Examples\IncorrectClients_EX.php" method="post">
 
   <div><input type="text" name="date" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите дату" /></div>                                                                  
 <br/><br/><br/><br/><br/><br/><br/><input type="submit" name="run" value='Выгрузить в Excel' class="my_button">
  </form></center>
<?php



                                                                                                              
 ?>
 <br/><br/><br/>   

</body>
</html>
