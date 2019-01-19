<html>    <title>Смена пароля</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylephp.css"  type="text/css">
 <style type="text/css">
 td
 {
 border: 1px #336699 solid;  
 }
 .my_button {
    width: 150px;
    height: 30px;
border-radius: 3px; box-shadow: 1px 1px 2px; font-size: 15px
}
.my_button1 {
    width: 200px;
    height: 35px;
border-radius: 10px; box-shadow: 0px 0px 5px; font-size: 16px
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
   <h3><div align="center" >Изменить пароль</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['parol']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['parol'])){
     header("Location: Menu.php");
     exit;                    }  
include 'gsotldb.php';

    ?> <br/><br/>  <br/>
     
    <form action="parol.php" method="post">  
<p><font size=4>Новый пароль: <input type="password" name="password" readonly onfocus="this.removeAttribute('readonly')" size="15" maxlength="15"><font color="red" size=4>если поле не заполнено, то будет сгенерирован случайный пароль из 4 цифр</font></p>
   <?php
  
    echo "<br/>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspФамилия Имя Отчество (дата рождения) ID";
    echo "<br/>";
echo "<br/><center><form method='post' action=''>
      <select name='categories'>
      <option value=''> &nbsp&nbsp&nbsp Выберите сотрудника </option>";        
          
 $result =  mysqli_query($link, "select ID, LName, FName, MName, Birthday
            from hb_employee 
            where hb_employee.fUser = '0' and hb_employee.PostID not in (20,0) and 
            hb_employee.ID not in (4192,1415,1560,1737,1237,1239,1240,1241,1521,1242,1243,1238,1244,233,733,232,234,235,498,499,1509,1510,3784,1015,1739,1738,571) or 
            hb_employee.fUser = '1' and hb_employee.ID not in (3877,3568,3706,3708,3709,3710,3711,3712) and hb_employee.Login is not NULL
            ORDER BY hb_employee.LName;") 
                or die ("<b>Ошибка подключения:</b>" . mysql_error()); 
 
while ($row = mysqli_fetch_array($result)){
    
echo "<option value=' ".$row['LName']." ".$row['FName']." ".$row['MName']." (".$row['Birthday'].") ".$row['ID']." '>".$row['LName']." ".$row['FName']." ".$row['MName']." (".$row['Birthday'].") ".$row['ID']."</option>";
}   
   
echo "<input type='submit' value='изменить пароль' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";
                                               
if ($_SERVER['REQUEST_METHOD'] == "POST")  {
 $string=@$_POST['categories'];
   $string_array = explode(")", $string);
   $a=@$string_array[1]-0;
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
        $pass=mt_rand(1000, 9999);
   }
 
 /*Action */                   
   $result=mysqli_query($link, "Select Password('$pass') into @pass");                
               $result =  mysqli_query($link, "UPDATE hb_employee SET hb_employee.crPassword=@pass where hb_employee.ID=$a");
         $res =  mysqli_query($link, "Select hb_employee.crPassword from hb_employee where hb_employee.ID='$a' ");
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
                        '$string ::crPassword=$pass')");
                    #    echo $passBD;
                    #    echo $pass_pass;
                     
echo "<h2 style=\"color:green;\">Пароль пользователя $string успешно изменён</h2>";
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