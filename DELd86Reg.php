<html>    <title>Удаление всех организаций в регионе</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylephp.css"  type="text/css">
 <style type="text/css">
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
include 'profilaktika.php'; 
?>
 </head>
<body>
<br/>
<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button>
</form>  <br/>
 <form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> <br/>
     <h3><div align="center" >Удаление всех организаций в регионе</div></h3>
<?php  
 
 session_start(); //Запускаем сессии
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login'];
 if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['DELd86Reg']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['DELd86Reg'])){
     header("Location: Menu.php");
     exit;                    }  
   
 include 'gsotldb.php'; 
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Аббревиатура";
 echo "<br/><center><form method='post' action=''>
      <select name='categories'>
      <option value=''> Выберите регион </option>";        
          
$result =  mysqli_query($link, "select hbc_divisions.Name from hbc_divisions order by Name;") 
                or die ("<b>Ошибка подключения:</b>" . mysqli_error()); 
 
while ($row = mysqli_fetch_array($result)){
   
echo "<option value=' ".$row['Name']." '> ".$row['Name']." </option>";
}  
echo "<input type='submit' value='Очистить регион' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";

 if ($_SERVER['REQUEST_METHOD'] == "POST")  {
  $string=@$_POST['categories'];
  $string_array = explode(" ", $string);
  $a=@$string_array[1];
  if (!empty($a))   {                          
/*Action */                                             
$res = mysqli_query($link, "update d80_clients
left join hbc_divisions on hbc_divisions.ID=d80_clients.ExDiv
SET d80_clients.ExDiv='254'
where hbc_divisions.Name='$a'"); 
  
if ($res == 'true')
{
$res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                                                     'Name=$a ::d86_clapc.SY_Void=1 ::d81_client2addr.SY_Void=1 ::d80_clients.ExDiv=254')"); 
echo "<h2 style=\"color:green;\">Регион $a успешно очищен!</h2>";
}
else
{
echo "Регион не очищен!";
}
                                             }
                                             }
                                              ?>
</body>
</html>