<html>  <title>Сроки исполнения работ</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
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
border-radius: 55px; box-shadow: 1px 1px 3px; font-size: 16px
}

 </style>
  
 <?php  
#include 'profilaktika.php'; 
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
</form>  <br/> 
   <h3><div align="center" >Сроки исполнения работ</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['order_deliver']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['order_deliver'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'gsotldb.php';
 
  if (isset($_SESSION['nodate'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Не выбрана дата!</font></div>          
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
<div id="error"><font size="6" color="red">Некорректно выбран интервал!</font></div>          
            <?php
            echo $_SESSION['Nocorrectdate'];
  unset($_SESSION['Nocorrectdate']);   
 }
  else 
  {
  unset($_SESSION['Nocorrectdate']);
 } 

 if (isset($_SESSION['gorod'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">В разработке</font></div>          
            <?php
  unset($_SESSION['gorod']);   
 }
  else 
  {
  unset($_SESSION['gorod']);
 }
 
 if (isset($_SESSION['tip'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">В разработке</font></div>          
            <?php
  unset($_SESSION['tip']);   
 }
  else 
  {
  unset($_SESSION['tip']);
 }
 
 if (isset($_SESSION['interval'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">Интервал не должен превышать месяц.</font></div>          
            <?php
  unset($_SESSION['interval']);   
 }
  else 
  {
  unset($_SESSION['interval']);
 }
  
 ?>       
 
 
                                          </select>
            <p><font size="4">интервал</font></p>
   	<script type="text/javascript" src="tcal.js"></script> 
    <form action="Examples\order_deliver_EX.php" method="post"> 

  <table align=center border="1">
   <tr>
    <th><div align="center"><b>с</b></div><div><input type="text" name="date_from" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите начальную дату" /></div><br/> </th>
    <th><select name="city">
  <option value="MOW">Москва</option>
  <option value="MO">Область</option>
</select></th>
   </tr>
   <tr>
    <td><div align="center"><b>по</b></div><div><input type="text" name="date_by" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите конечную дату" /></div><br/> </td>
    <td><select name="parcell">
  <option disabled value="Zakazy">Заказы</option>
  <option value="Dostavki">Доставки</option>
</select></td>
  </tr>
 </table>
 </body>
</html> 
    
      
  <br/><br/><div align="center"><input type="submit" name="run" value='Выгрузить в Excel' class="my_button">
  </form> <br/><br/>
  <center><font size='4' color='blue'>Процесс может занять длительное время</font>
 <br/><br/><br/>   

</body>
</html>
