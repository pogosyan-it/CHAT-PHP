<html>   <title>Курьер/Автокурьер</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylephp.css"  type="text/css">
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
   <h3><div align="center" >Создать пользователя "Курьер/Автокурьер"</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['kurier']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['kurier'])){
     header("Location: Menu.php");
     exit;                    }  
       $symembID=$_SESSION['symembID']; 
include 'gsotldb.php';
if (!@($_POST['run']))
  {
?>    
<center><br/><br/>
 <p><font size="5">Заполните все поля</font></p>
 <form action="kurier.php" name="mainform" method="post"></center>
<label for="LName">Фамилия:</label><br/>
<input type="text" name="LName" size="20"><br/>
<label for="FName">Имя:</label><br/>
<input type="text" name="FName" size="20"><br/>
<label for="MName">Отчество:</label><br/>
<input type="text" name="MName" size="20"><br/>
        
       <label for="Day">Дата Рождения:</label><br/>
       <select name="Day">
       <?php
       for ($i=1; $i<32; $i++) {echo "<option value='$i'>$i</option>";}
       ?>
       
                    </select>
    <select name="Month">
        <option value="01">Январь</option>
        <option value="02">Февраль</option>
        <option value="03">Март</option><br>
        <option value="04">Апрель</option>
        <option value="05">Май</option>
        <option value="06">Июнь</option>
        <option value="07">Июль</option>
        <option value="08">Август</option>
        <option value="09">Сентябрь</option>
        <option value="10">Октябрь</option>
        <option value="11">Ноябрь</option>
        <option value="12">Декабрь</option>
            </select>      
  
<select name="Year">
<?php
       for ($j=1900; $j<2020; $j++) {echo "<option value='$j'>$j</option>";}
?>
      </select>
       <br/>
          
  <br/><br/><input type="submit" name="run" value="Создать пользователя «Курьер/Автокурьер»" class="my_button">
  </form>
<?php
}
else
{ 

  
 $a = mb_convert_case($_POST['LName'],MB_CASE_TITLE,'cp-1251');
 $b = mb_convert_case($_POST['FName'],MB_CASE_TITLE,'cp-1251');
 $c = mb_convert_case($_POST['MName'],MB_CASE_TITLE,'cp-1251');
# $e = $_POST['Login'];
# $pass=mt_rand(1000, 9999);
 $day = $_POST['Day'];  
 $month = $_POST['Month'];
 $year =  $_POST['Year'];
 
 if( !empty($a) && !empty($b) && !empty($c)  )
 {
     #$pattern1 = "/^[a-zA-Z0-9_]+$/i";
     $pattern2 = "/^[".chr(0x7F)."-".chr(0xff)."_-]+$/";
     
     $found1 = (preg_match($pattern2,$a));
     $found2 = (preg_match($pattern2,$b));
     $found3 = (preg_match($pattern2,$c));
     #$found4 = (preg_match($pattern1,$e));
                     
   if ( $found1 && $found2 && $found3 )    
   
    {                                  
 /*Action */ 				  
 $result =  mysqli_query($link, "Select CONCAT('$year','-','$month','-','$day') into @date");
 $result =  mysqli_query($link, "Select (Left('$b',1)) into @in1"); 
 $result =  mysqli_query($link, "Select (Left('$c',1)) into @in2");
 $result =  mysqli_query($link, "Select CONCAT ('$a',' ',@in1,'.',@in2,'.') into @sname");
 $result =  mysqli_query($link, "Insert into hb_employee (DivisionID, DepartamentID, PostID) values('1', '18', '7')");
 
 $result =  mysqli_query($link, "Select MAX(hb_employee.ID) from hb_employee into @maxid");
 $mysql = mysqli_query($link, "Select MAX(`ID`) as maxid from `hb_employee`;");
                  while ($row = mysqli_fetch_assoc($mysql))
                  {
                    $mid=$row['maxid'];
                  
                  }
 
 $result =  mysqli_query($link, "Update hb_employee SET hb_employee.SY_MembID='$symembID', hb_employee.LName='$a', hb_employee.FName='$b', 
                     hb_employee.MName='$c', hb_employee.SName=@sname, hb_employee.fUser='0', hb_employee.Birthday=@date where hb_employee.ID=@maxid"); 
 $mysql = mysqli_query($link, "Select `SName` from `hb_employee` where `ID` in (Select MAX(`ID`) from `hb_employee`);");
                  while ($row = mysqli_fetch_assoc($mysql))
                  {
                    $sname=$row['SName'];
                  
                  }
 $result =  mysqli_query($link_mto, "Insert into Employee values('$mid', NOW(), '$symembID', '1', '18', '7', '$a', '$b','$c', '$sname');");                     
                                                                       
 
if  ($result == 'true') { 
$res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                        'LName=$a::FName=$b ::MName=$c ::fUser=0 ::DivisionID=1 ::DepartamentID=18 ::PostID=7 ::$year-$month-$day')");  
echo "<h2 style=\"color:green;\">Пользователь успешно создан!</h2>"; 
echo "Фамилия: $a";
echo "<br/>";
echo "Имя: $b";
echo "<br/>";
echo "Отчество: $c";
}
else		                   
 {
echo "<h2 style=\"color:red;\">Произошла ошибка при создании пользователя, обратитесь в IT отдел!</h2>";
}                                    
}
 
else    {
            echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><h2 style=\"color:red;\">Поля некорректно заполнены</h2>";
?>
<form action="kurier.php" method=GET>
<input  <button  style="background: #DCDCDC; width: 90px; height: 35px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   type="submit" value="Исправить"></button></form>
            <?php
            }
          }            
          else    {
            echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><h2 style=\"color:red;\">Одно из полей не заполнено</h2>";
?>
<form action="kurier.php" method=GET>
<input  <button  style="background: #DCDCDC; width: 90px; height: 35px; border-radius: 5px; white-space: pre-line; box-shadow: 0px 1px 3px; font-size: 15px; text-align: left;" 
   type="submit" value="Исправить"></button></form>
            <?php
           }    
              }
 ?>
 <br/><br/><br/>   

</body>
</html>