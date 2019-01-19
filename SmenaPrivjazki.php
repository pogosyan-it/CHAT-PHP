<html>    <title>Областная принадлежность НП</title>
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
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center" >Областная принадлежность НП</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['SmenaPrivjazki']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['SmenaPrivjazki'])){
     header("Location: Menu.php");
     exit;                    }  
    include 'gsotldb.php'; 

    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Населенный пункт";
 echo "<br/><center><form method='post' action=''>
      <select name='categories'>
      <option value=''> Выберите нп </option>";        
          
$result =  mysqli_query ($link, "select distinct hbc_cities.Name from hbc_cities where hbc_cities.Name not like '%(%)%' and hbc_cities.CountryID=7 and hbc_cities.Name in
                                 (select hbc_cities.Name from hbc_cities where hbc_cities.CountryID=7 group by hbc_cities.Name having count(hbc_cities.Name)>1) order by hbc_cities.Name;") 
                or die ("<b>Ошибка подключения:</b>" . mysql_error()); 
 
while ($row = mysqli_fetch_assoc($result)){
   
echo "<option value='".$row['Name']."'>".$row['Name']." </option>";
}  
echo "<input type='submit' value='Переименовать' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";

 if ($_SERVER['REQUEST_METHOD'] == "POST")  {
  $gorod=@$_POST['categories'];
/*Action */   
   $result = mysqli_query($link,"UPDATE hbc_cities
left join hbc_fedunits on hbc_fedunits.ID = hbc_cities.FedUnitID
SET hbc_cities.Name = CONCAT (hbc_cities.Name, ' (', hbc_fedunits.Name, ')')
where hbc_cities.Name = '$gorod'");

   #echo '<meta http-equiv="refresh" content="5; url=http://gsot.corp/SmenaPrivjazki.php">'; 
  if (!empty ($gorod)){
if  ($result == false) 
{echo "<h2 style=\"color:red;\">Ошибка</h2>";}
             else
             {  $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                                                     'hbc_cities.Name=$gorod')");
             echo "<h2 style=\"color:green;\">$gorod успешно переименован</h2>";}                                     
                                             }                                                      
                                             }
                                              ?>
</body>
</html>