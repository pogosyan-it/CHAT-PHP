<html>    <title>Просмотр ВП</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
  <script src="vyvodVP1.js"></script>      
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
 <style type="text/css">
   table {
    width: 440px; /* Ширина таблицы */
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
#area { resize: none; overflow: hidden; }
 </style>
 
 <?php 
 @ include 'TehRaboty.php';  
include 'profilaktika.php'; 
?>
 </head>
<body>

  <script>
$(document).ready(function(){
	$('#area').keypress(function(e){
	  if(e.which == 13){
		   $('form').submit();
	   }
	});
});
</script>
 <br/>  
<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form>  <br/> 
   <h3><div align="center" >Просмотреть внутреннюю почту</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['vyvodVP1']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['vyvodVP1'])){
     header("Location: Menu.php");
     exit;                    }  
 
   include 'gsotldb.php'; 
  
     #$qwe = 'Нет такой накладной';
     if (isset($_SESSION['netnakl'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Нет такой накладной!</font></div>          
            <?php
   unset($_SESSION['netnakl']);   
 }
  else 
  {
  unset($_SESSION['netnakl']);
 }
  
     if (isset($_SESSION['error'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Неверный номер!</font></div>          
            <?php
   unset($_SESSION['error']);   
 }
  else 
  {
  unset($_SESSION['error']);
 } 
 
  if (isset($_SESSION['rusnakl'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Не внутренняя почта КОРПА</font></div>          
            <?php
   unset($_SESSION['rusnakl']);   
 }
  else 
  {
  unset($_SESSION['rusnakl']);
 }       

 if (isset($_SESSION['myresult']))
  { 
  ?>
<div id="error"><font size="6" color="green"><?php echo $_SESSION['myresult']; ?> </font></div>                    
<?php
   unset($_SESSION['myresult']); 
 }
  else 
  {
 unset($_SESSION['myresult']); 
  }    
  
   if (isset($_SESSION['netdiscr'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Нет такого содержимого!</font></div>          
            <?php
   unset($_SESSION['netdiscr']);   
 }
  else 
  {
  unset($_SESSION['netdiscr']);
 } 

 
?>  
<br/>

    <form action="vyvodVP2.php" method="post">  
    <table>
   
    <tr>
        <td align="right">№ накладной ВП:</td> 
       <td><p><textarea id="area" autofocus maxlength="15" rows="1"  cols="15" name="nomer"></textarea></p></td>  
    </tr>
    <tr>
        <td align="right">Поиск по содержимому:</td> 
       <td><p><textarea id="area" autofocus maxlength="15" rows="1"  cols="15" name="soderjimoe"></textarea></p></td>  
    </tr>
   
</table>
                
<br/> 
   <input type="submit" name="run" value="Найти" class="my_button">
    </form>   
    
</body>
</html>