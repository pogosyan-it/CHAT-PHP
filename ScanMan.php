<html>    <title>Сканирование накладных в манифесте</title>
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
   <h3><div align="center" >Сканирование накладных в манифесте</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['ScanMan']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['ScanMan'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'profilaktika.php'; 
     include 'gsotldb.php'; 
 
  
   if (isset($_SESSION['nomanifest'])) 
  {   
  ?>     
  <div id="error"><font size="6" color="red">Введите номер манифеста</font></div>          
            <?php
  unset($_SESSION['nomanifest']);   
 }
  else 
  {
  unset($_SESSION['nomanifest']);
 }
 
 if (isset($_SESSION['nowaybill'])) 
  {   
  ?>     
  <div id="error"><font size="6" color="red">Не найдено записей</font></div>          
            <?php
  unset($_SESSION['nowaybill']);   
 }
  else 
  {
  unset($_SESSION['nowaybill']);
 }
 
   ?> 
<table border=2px>

  <form name="MyForm" method="post">
     
   
 <td><label for="WaybillNum"><center><font size="4" color="black"><b>Номер Манифеста:</b</font></label> 
                    <center><br/><input type="text" name="ManifestNum" autofocus size="20"></td><br/>
                                              
     
    
    </table>
    
<?php
echo "<br/>"; 
echo "<center><font size='4' color='blue'>Процесс может занять длительное время</font>"; 				
   echo "<br/>";
   echo "<br/>";

echo "<center><button type='submit' formaction='Examples\ScanManExcel.php' class='my_button'>Вывод результата</button>"; 
       echo "</center>";   
echo "<br/>";

 ?> 
 
    
 




 
</body>
</html>