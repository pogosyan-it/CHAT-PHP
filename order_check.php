<html>    <title>Проверка Заказа</title>
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
      
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center" >Проверка Заказов</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['order_check']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['order_check'])){
     header("Location: Menu.php");
     exit;                    }  
include 'gsotldb.php';

    ?> <br/>
     
    <form action="order_check.php" method="post"> 
    <table>
    <tr><td>
  <p><b>Список Заказов:</b></p>  </td>
  <td> <p><b>Результат:</b></p>    </td> </tr>
<tr> <td> <p><textarea rows="30" cols="16" name="order"></textarea></p>
  <p><input type='submit' value='Проверка' class='my_button'</input></p>
  </form>    </td>

<?php
$a=$_POST['order'];
$order = explode("\r\n", $a);
$len=mb_substr_count("$a", "\r\n");
      ?> <td> <?php
for ($i = 0; $i <= $len; $i++) {
$order[$i]=mb_strtolower($order[$i], 'cp1251');
$new_order='9'.$order[$i];
#echo "new_order=$new_order";
$result =  mysqli_query($link, "Select d15_departures.PickUpCode as order_db from d15_departures where d15_departures.PickUpCode in ('$order[$i]','$new_order');")
                or die ("<b>Ошибка подключения:</b>" . mysql_error());
     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{
              $orderDB=mb_strtolower($row['order_db'],'cp1251');
              #echo $del_user;			  
} 
#echo "orderDB=$orderDB";
   if (!empty($order[$i]))    {         
     if ($orderDB==$order[$i] ){echo "$order[$i] Есть в базе";}
     elseif ($orderDB==$new_order) {echo "$new_order Есть в базе";}
     else {echo "<font color=\"red\"> $order[$i] Нет в базе</font>";} 
                              }
 
echo "<br/>";
}                     
 ?>  
  </td> </tr>                                       
  </table>

</body>
</html>