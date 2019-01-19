<html>    <title>Изменить свой пароль</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylephp.css"  type="text/css">
 <style type="text/css">
 td
 {
 border: 1px #336699 solid;  
 }
 .my_button {
    width: 190px;
    height: 30px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}
 </style>
 <?php  
include 'profilaktika.php';
include 'gsotldb.php'; 
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
</form>      <br/> 
   <h3><div align="center" >Изменение своего пароля на сайт и GSoT</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['smenaPass']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['smenaPass'])){
     header("Location: Menu.php");
     exit;                    }   
     ?> <br/><br/>  <br/>
      <form action="smenaPass.php" method="post">  
<p><font size=4>Новый пароль: <input type="password" name="password" readonly onfocus="this.removeAttribute('readonly')" size="15" maxlength="15"></p>
   <?php
 
 
   
echo "<input type='submit' value='изменить пароль' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";
                                               
if ($_SERVER['REQUEST_METHOD'] == "POST")  {
 #$string=@$_POST['categories'];
 #  $string_array = explode(")", $string);
  # $a=@$string_array[1]-0;
    if (!empty($_POST['password']))  { 
    $pass = $_POST['password'];
   # $pass=iconv("utf-8", "windows-1251", $pass);
    if(!preg_match('|^[A-Z0-9]+$|i', $pass))
        {
       echo "<h2 style=\"color:red;\">Пароль нельзя создавать с русскими буквами</h2>";  
       exit;
         }     
     }
    else {
       echo "<h2 style=\"color:red;\">Пароль не может быть пустым</h2>"; 
       exit; 
   }
 
 /*Action */ 
 $res = mysqli_query($link, "select ID from hb_employee where Login='$Login'");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
           {
						   $ID=$row['ID'];
					   }                  
   $result=mysqli_query($link, "Select Password('$pass') into @pass");                
               $result =  mysqli_query($link, "UPDATE hb_employee SET hb_employee.crPassword=@pass where hb_employee.ID=$ID");
         $res =  mysqli_query($link, "Select hb_employee.crPassword from hb_employee where hb_employee.ID='$ID' ");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
{
              $passBD=$row["crPassword"];
              #echo $del_user;			  
}
$res =  mysqli_query($link, "SELECT PASSWORD('$pass')");
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
{
              $pass_pass=$row["PASSWORD('$pass')"];
              #echo $del_user;			  
}
if  (@$passBD==$pass_pass) {
 $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                        '$Login ::crPassword=$pass')");
                    #    echo $passBD;
                    #    echo $pass_pass;
                     
echo "<h2 style=\"color:green;\">Ваш пароль успешно изменён</h2>";
echo "<h2 style=\"color:green;\">Новый пароль:$pass</h2>";
                        }
else 
{
echo "<h2 style=\"color:red;\">Ошибка, пароль не изменён</h2>";
#echo $passBD;
                      #  echo $pass_pass;
}		
        
                                             }
     ?>                                                                                

</body>
</html>