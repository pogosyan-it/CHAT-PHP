<html>  <title>Прогон ВП</title>
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
    width: 420px;
    height: 50px;
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
   <h3><div align="center" >Прогон ВП</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['VP']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['VP'])){
     header("Location: Menu.php");
     exit;                    }  
   
 include 'gsotldb.php';
if (!@($_POST['run']))
  {
?>    
<br/>
<script type="text/javascript" src="tcal.js"></script> 
 <p><font size="5">Выберите по какую дату включительно прогнать ВП</font></p>
  
 <center><form action="VP.php" method="post">
 
   <div><input type="text" name="date" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите дату" /></div>                                                                  
 <br/><br/><br/><br/><br/><br/><br/><br/><br/><input type="submit" name="run" value='Прогнать ВП' class="my_button">
  </form></center>
<?php
}
else
{ 
 $n = $_POST['date']; 
 $kz = '"кайзер"';
 /*Action */      
     $result =  mysqli_query($link, "update d15_departures SET d15_departures.fSidePost = '1'
where (WayBillNum REGEXP('[А-я]') or WayBillNum REGEXP('[A-z]')) and fWayBill>0 and fSidePost<1 and SY_Void<1 
and WayBillNum <>'Снят!%' and S_Name not in ('$kz','кайзер','кайзэр','каизер','каизэр','каизир','кайзир') and SY_LastEdit<'$n' 
or (WayBillNum REGEXP('[А-я]') or WayBillNum REGEXP('[A-z]')) and fWayBill>0 and fSidePost<1 and SY_Void<1 and WayBillNum <>'Снят!%' and S_Name is NULL and SY_LastEdit<'$n'
order by WayBillDate,WayBillNum;");
     $result =  mysqli_query($link, "update d15_departures SET d15_departures.fSidePost=0 where d15_departures.fSidePost=1 and d15_departures.Sh_EWeight > 1 
                            and d15_departures.FromDivID in ('52', '104', '130');");                       
     
     
    if  ($result == 'true') {
     $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                        'fSidePost=1 ::SY_LastEdit<$n ::fSidePost=0')");  
    echo "<h2 style=\"color:green;\"> Успешный прогон ВП по $n </h2>"; 
        }
    else
    {
    echo "<h2 style=\"color:red;\">Произошла ошибка при прогоне ВП, обратитесь в IT отдел!</h2>";
    } 
    }
                                                                                                              
 ?>
 <br/><br/><br/>   

</body>
</html>
