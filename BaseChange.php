<html>    <title>Архивные базы</title>
<head> <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
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

<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['BaseChange']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['BaseChange'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'profilaktika.php';  

$IPopen=$_SESSION['IPopen'];
foreach ( $IPopen as $perebor  )  if ($perebor == $LogIP)  {
        $a='TRUE';                                                             
     ?>
     <div align="center" style="font-size:21px" ><b>Закрываете GSoT.</b></div>
  <div align="center" style="font-size:21px" ><b>Скачиваете файл с настройками и запускаете его.</b></div>
  <div align="center" style="font-size:21px" ><b>Меняете дату на компе и запускаете GSoT.</b></div>    
  <br/>
     <form action='/base/GSoT_Текущая.bat'>
    <input <button style="background: #00BFFF; width: 300px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type='submit' value='Скачать настройки текущей базы'>
</form>    

 <form action='/base/GSoT_2017.bat'>
    <input <button style="background: #E0FFFF; width: 300px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type='submit' value='Скачать настройки базы 2017 года'>
</form> 

 <form action='/base/GSoT_2016.bat'>
    <input <button style="background: #E0FFFF; width: 300px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type='submit' value='Скачать настройки базы 2016 года'>
</form>  

 <form action='/base/GSoT_2015.bat'>
    <input <button style="background: #E0FFFF; width: 300px; height: 35px;
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type='submit' value='Скачать настройки базы 2015 года'>
</form> 

<form action='/base/GSoT_2014.bat'>
    <input <button style="background: #E0FFFF; width: 300px; height: 35px;
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type='submit' value='Скачать настройки базы 2014 года'>
</form>   

 <h2><div align="center" >Не забудьте сменить дату обратно</div></h3> <?php 
                                                            } 
    if (@$a != 'TRUE') {  echo "<br/><h2 style=\"color:red;\">У данного IP нет доступа к архивным базам</h2>"; }

 ?> 
 
</body>
</html>