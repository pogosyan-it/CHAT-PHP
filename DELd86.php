<html>    <title>Удаление организации</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
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
</form>   <br/>
 <form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> <br/>
  <h3><div align="center" >Удаление организации в регионе</div></h3>
<?php  
 
 session_start(); //Запускаем сессии
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login'];
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['DELd86']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['DELd86'])){
     header("Location: Menu.php");
     exit;                    }  
  
    include 'gsotldb.php'; 
if (!$link) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
} 
                                
?>    
<br/><br/>   <br/>    
      

 <form action="DELd86.php" name="mainform" method="post">  
<font size="4"><label for="org1">Название&nbspорганизации:</font></label><br/>
 <br/><input type="text" name="organization" size="50"><br/>   
      <br/>    
         
      
                   </select>
  <?php 
  $org=@$_POST['organization'];

        #echo "Фамилия Имя Отчество (дата рождения) ID";
    echo "<br/>";
    echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Аббревиатура";
    echo "<br/><center><form method='post' action=''>
      <select name='city_names'>
      <option value=''> Выберите регион </option>";        
          
$resul =  mysqli_query($link, "select hbc_divisions.Name from hbc_divisions order by Name") ;
                
 
while ($row = mysqli_fetch_assoc($resul)){
 

echo "<option value=' ".$row['Name']." '>".$row['Name']." </option>";
 
}
  
$abr=$_POST['city_names'];
$abr_1 = explode(" ", $abr);  
$abr = $abr_1[1];       
echo "<input type='submit' value='Удалить организацию' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";
if (!empty($org))     {
if ($_SERVER['REQUEST_METHOD'] == "POST")  {

 
        $resul_select = mysqli_query($link, "select d80_clients.FullName from d80_clients
        left join hbc_divisions on hbc_divisions.ID=d80_clients.ExDiv where d80_clients.FullName ='$org' and hbc_divisions.Name='$abr'") 
                        or die (mysqli_error($link));
            while ($row = mysqli_fetch_array($resul_select, MYSQL_ASSOC)) {
        $peremen=$row["FullName"];
                                                                          }
/*Action */		if  (!empty($peremen)) {                                 
$result = mysqli_query($link, "update d80_clients
left join hbc_divisions on hbc_divisions.ID=d80_clients.ExDiv
SET d80_clients.ExDiv='254'
where hbc_divisions.Name='$abr' and d80_clients.FullName ='$org'") 
or die (mysqli_error($link));
                                                  

      if  ($result == 'true') {
      $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                                                     'Name=$abr ::FullName =$org ::d86_clapc.SY_Void=1 ::d81_client2addr.SY_Void=1 ::d80_clients.ExDiv=254')");      
echo "<h2 style=\"color:green;\">Организация $org в регионе $abr удалена!</h2>"; 
                              }
      else		                   
               {
echo "<h2 style=\"color:red;\">Произошла ошибка при удалении, обратитесь в IT отдел!</h2>";
                } 
                           }  
    else    {
            echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><h2 style=\"color:red;\">Организации $org в регионе $abr не найдено!</h2>";
            #echo "<a href='javascript:history.go(-1)'>Назад</a>";
            }                                
    
              
 }  
 else    {
            echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><h2 style=\"color:red;\">Одно из полей не заполнено</h2>";
#echo "<a href='javascript:history.go(-1)'>Назад</a>";
        }
   }           

?>
</body>
</html>