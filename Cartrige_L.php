<html>    <title>Заказ картриджей</title>
<head>    <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251"> 
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
 <link rel="stylesheet" href="tcal.css">  
 <style type="text/css">
   table {
    width: 300px; /* Ширина таблицы */
    margin: auto; /* Выравниваем таблицу по центру окна  */
   }
      td
 {
 border: 1px #336699 solid;  
 }
 .my_button {
    width: 220px;
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
<br/><form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center" >Заказ картриджа</div></h3>
<?php
session_start(); //Запускаем сессии   
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['Cartrige']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['Cartrige'])){
     header("Location: Menu.php");
     exit;                    }  

     $linkC = mysqli_connect( 
         '10.10.1.2',  // Хост, к которому мы подключаемся 
            'root',      // Имя пользователя  
            '2me32jvppn',    // Используемый пароль 
            'Cartriges');     // База данных для запросов по умолчанию  
    $linkC->set_charset("cp1251");

if (!$linkC) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
}
    
?>  
 
<table>
    <tr>               
            <td><?php 
   echo "<h2 style=><center><font size=\"3\">Модель принтера</font>";
     echo "<br/><center><form method='post' action=''>
      <br/><select name='printer_model'>
      <option value=''>Выберите модель принтера</option>";     
	        
$printer_model =  mysqli_query($linkC, "select Printers.printer_model, Cartrige_price.Cartrige_model
                                        from Printers
                                        left join Cartrige_price on Cartrige_price.printer_id=Printers.id") ;                 
 
while ($row = mysqli_fetch_assoc($printer_model)){
echo "<option value='".$row['printer_model'].")".$row['Cartrige_model']."'>".$row['printer_model']." </option>";
                                                }?>
    </td>
          <td>
       <?php 
   echo "<h2 style=\"\"><center><font size=\"3\">Отдел</font>";
     echo "<br/>";
   echo "<br/><center><form method='post' action=''>
      <select name='Department'>
      <option value=''>Выберите отдел</option>";   
	                                               
$resul =  mysqli_query($linkC, "select Department, Mail from Departments");               
 while ($row = mysqli_fetch_assoc($resul)){ 
echo "<option value='".$row['Department'].")".$row['Mail']."'>".$row['Department']." </option>";
                                          }  
?>
   </td>      
        <td><label for="number"><center><h2 style=""><font size="3">Количество картриджей:</font></label> 
	<center>	<select name="number">
        <option value="1">1</option>
        <option value="2">2</option>
          </select></td>
        </tr>
    <tr>
        <td colspan="3"> 
<?php 		
echo "<center><input type='submit'  name='zakaz' value='Отправить заявку' class='my_button'</input>"; 
echo "</select></form></center>"; 
 ?> 
    </td>
    </tr>
</table>
<?php  
  include 'gsotldb.php';
$resul =  mysqli_query($link, "select SName from hb_employee where Login='Pogosyan'");
  while ($row = mysqli_fetch_assoc($resul)){ 
                 $sname=$row['SName'];
}  
$P_model=@$_POST['printer_model']; 
$Dep=@$_POST['Department']; 
$number=@$_POST['number'];
$string_array=explode(")", $Dep); 
$string_array1=explode(")", $P_model);
$P_model=@$string_array1[0];
$M_cart=@$string_array1[1]; 
$DepMail=@$string_array[1];
$Dep=@$string_array[0];
#$Department=iconv("cp1251", "utf-8", $Department);
$tema=iconv("cp1251", "utf-8", 'Картридж');
#$body='Отдел:'.$Dep. "\r\n". 'Модель принтера:'.$P_model.', количество:'.$number.', Модель картриджа:'.$M_cart.', Заказчик:'.$sname.', IP:'.$LogIP;  
 $myarray=array( 'Отдел:' => $Dep, 'Модель принтера:' => $P_model, 'Количество:' => $number, 'Модель картриджа:' => $M_cart, 
                       'Заказчик:' => $sname, 'IP заказчика:' => $LogIP );
       
  
if (@$_POST['zakaz'] == true){

if (empty($P_model) or empty($Dep)) {echo "<h2 style=\"color:red;\">выберите модель принтера и отдел</h2>"; exit;} 
 
$res =  mysqli_query($linkC, "Select Departments.id from Departments where Departments.Department='$Dep' into @dep_id");            
$res =  mysqli_query($linkC, "Select Printers.id from Printers where Printers.printer_model='$P_model' into @pr_id");
$res1 =  mysqli_query($linkC, "Insert into General (id_printer, id_department, quantity, user) values (@pr_id, @dep_id, '$number', '$Login $LogIP')");  
    if ($res1==true) {
 
foreach ( $myarray as $k=>$v )  {
      $fd = fopen("$Login", 'a+') or die("не удалось создать файл");
      fwrite($fd, iconv("cp1251", "utf-8", $k.$v."\r\n")); 
      #fseek($fd, 0, SEEK_END);
    }

fclose($fd);
echo exec(sprintf("LANG=ru_RU.utf8; mail -s '$tema' -r '$DepMail' it@corp.dimex.ws < /var/www/'$Login'", escapeshellarg($Login))); 
 unlink("$Login");
 
 echo "<h2 style=\"color:green;\">Заявка на картридж успешно отправлена в IT отдел</h2>";      }
else{ echo "<h2 style=\"color:red;\">Произошла ошибка при создании заявки</h2>";}
 }  
 if ($Login=='Pogosyan' or $Login=='Admin' or $Login=='VeklichYaA' or $Login=='Iskandyarova'){   ?>
    <h3><div align="center" >Статистика по картриджам</div></h3>
   <p><font size="4">интервал</font></p>
   	<script type="text/javascript" src="tcal.js"></script> 
    <form action="Examples\Cartrige_EX.php" method="post"> 
		с<div><input type="text" name="date_from" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите начальную дату" /></div><br/> 
    по<div><input type="text" name="date_by" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите конечную дату" /></div>   
  <br/><br/><input type="submit" name="cart" value='Выгрузить в Excel' class="my_button">  
  </form> 
 
<?php
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
  }
   ?>
</body>
</html>