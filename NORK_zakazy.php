<html>  <title>Отчет по реализации услуг</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
<link rel="stylesheet" href="tcal.css">        
 <style type="text/css">
 td
 {
 border: 1px #336699 solid;
 }
.my_button {
    width: 190px;
    height: 40px;
border-radius: 55px; box-shadow: 1px 1px 3px; font-size: 16px
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
   <h3><div align="center" >Отчет по реализации услуг</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['NORK_zakazy']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['NORK_zakazy'])){
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
 
 if (isset($_SESSION['Nocorrectdate'])) 
  { 
  ?>
<div id="errorchl"><font size="6" color="red">Некорректно выбран интервал!</font></div>          
            <?php
           # echo $_SESSION['Nocorrectdate'];
  unset($_SESSION['Nocorrectdate']);   
 }
  else 
  {
  unset($_SESSION['Nocorrectdate']);
 } 
 ?>      
 
                                          </select>
            <p><font size="4">интервал</font></p>
   	<script type="text/javascript" src="tcal.js"></script> 
    <form action="Examples\NORK_zakazy_Ex.php" method="post"> 
		с<div><input type="text" name="date_from" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите начальную дату" /></div><br/> 
    по<div><input type="text" name="date_by" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите конечную дату" /></div>   
  <br/><br/><input type="submit" name="run" value='Выгрузить в Excel' class="my_button">  
  </form>
 <center><font size='4' color='blue'>Процесс может занять длительное время</font>
  
 <br/><br/>  

</body>
</html>
