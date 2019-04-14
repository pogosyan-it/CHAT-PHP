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
 vertical-align: top;
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
    <tr><td>
<?php 
     echo "<h2 style=><center><font size=\"3\">Модель принтера</font>";
     echo "<br/><center><form method='post' action=''>
     <br/><select name='printer_model'>
     <option value=''>Выберите модель принтера</option>";     
	        
                    $printer_model =  mysqli_query($linkC, "select Printers.printer_model from Printers
                                                             left join Cartrige_price on Cartrige_price.printer_id=Printers.id") ;                 
                                                   while ($row = mysqli_fetch_assoc($printer_model))
                                      {
                                            echo "<option value='".$row['printer_model']."'>".$row['printer_model']." </option>";
                                      }
                                                  
$P_model=$_POST['printer_model'];
                     
                     $res =  mysqli_query($linkC, "select Cartrige_price.Cartrige_model as model from Printers
                                                   left join Cartrige_price on Cartrige_price.printer_id=Printers.id where Printers.printer_model='$P_model'"  ) ;                 
 
                                          while ($row = mysqli_fetch_assoc($res))
                                       {
$cart=$row['model'];
                                       } 
                                              
?>    
    </td><td>
<?php  
     echo "<h2 style=\"\"><center><font size=\"3\">Отдел</font>";
     echo "<br/>";
     echo "<br/><center><form method='post' action=''>
      <select name='Department'>
      <option value=''>Выберите отдел</option>";   
	                                               
                  $res =  mysqli_query($linkC, "select Department from Departments order by Department"); 
                                                 
                                         while ($row = mysqli_fetch_assoc($res))
                                        { 
                                               echo "<option value='".$row['Department']."'>".$row['Department']." </option>";
                                        }  
$Dep=$_POST['Department'];  
                  $res =  mysqli_query($linkC, "select Mail from Departments where Department='$Dep'"); 
                                         while ($row = mysqli_fetch_assoc($res))
                                        { 
$mail=$row['Mail'];
                                        }                                         
?>
   </td>      
        <td><label for="number"><center><font size="3"><b>Количество</b></font></label> 
	       <label for="number"><center><font size="3"><b></b></font></label> 
        <center><select name="number">
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
                $result =  mysqli_query($link, "select SName from hb_employee where Login='$Login'");
                                       while ($row = mysqli_fetch_assoc($result))
                                      { 
$sname=$row['SName'];
                                      }  
$number=@$_POST['number'];

$tema=iconv("cp1251", "utf-8", 'Картридж');

$myarray=array( 'Отдел:' => $Dep, 'Модель принтера:' => $P_model, 'Количество:' => $number, 'Модель картриджа:' => $cart, 
                       'Заказчик:' => $sname, 'IP заказчика:' => $LogIP );
   
 
if (@$_POST['zakaz'] == true)
                                    { 
   if (empty($P_model) or empty($Dep))
                                    {
                                       echo "<h2 style=\"color:red;\">выберите модель принтера и отдел</h2>"; exit;
                                    } 
 
              $res =  mysqli_query($linkC, "Select Departments.id from Departments where Departments.Department='$Dep' into @dep_id");            
              $res =  mysqli_query($linkC, "Select Printers.id from Printers where Printers.printer_model='$P_model' into @pr_id");
              $res1 =  mysqli_query($linkC, "Insert into General (id_printer, id_department, quantity, user) values (@pr_id, @dep_id, '$number', '$Login $LogIP')");  
   if ($res1==true) 
                 {
 
                foreach ( $myarray as $k=>$v )  
  #                      if ($v==$cart) {break;} 
  #                      else {   
                                   {
                                      $fd = fopen("$Login", 'a+') or die("не удалось создать файл");
                                      fwrite($fd, iconv("cp1251", "utf-8", $k.$v."\r\n")); 
                                   }  
 #                             }
    
fclose($fd);      
#mail -s \'TEST\' -a /var/www/files/2017-06-05.txt it@corp.dimex.ws
               
              echo exec(sprintf("LANG=ru_RU.utf8; mail -s '$tema' -r '$mail' it@int.dmcorp.ru < /var/www/'$Login'", escapeshellarg($Login)), $hzchtoeto, $proverka); 
              echo exec(sprintf("LANG=ru_RU.utf8; cat /var/www/'$Login' | head -n 4 | mail -s '$tema' -r '$mail' finkontrol@dmcorp.ru", escapeshellarg($Login)));
              #echo exec(sprintf("LANG=ru_RU.utf8; cat /var/www/'$Login' | head -n 5 | mail -s '$tema' -r '$mail' client@dmcorp.ru", escapeshellarg($Login)));
unlink("$Login");
if (!$proverka) {
   echo "<h2 style=\"color:green;\">Заявка на картридж успешно отправлена в IT отдел!</h2>";
} else {
    echo "<h1 style=\"color:red;\">Произошла ошибка при создании заявки, сообщите в IT отдел!</h1>"; 
}

 #$_SESSION['ok'] = '';          
# header('location:Cartrige.php');                
               }
    else         { 
                   echo "<h2 style=\"color:red;\">Произошла ошибка при создании заявки</h2>";}
                 }
 if ($Login=='Pogosyan' or $Login=='Admin' or $Login=='Shalganova' or $Login=='Pahomova' or $Login=='Iskandyarova')
                 {
?>
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