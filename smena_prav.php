<html>    <title>Сменить права</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylephp.css"  type="text/css">
 <style type="text/css">
 td
 {
 border: 1px #336699 solid;  
 }
 .my_button {
    width: 130px;
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
   <h3><div align="center" >Изменить права доступа (уволить)</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['smena_prav']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['smena_prav'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'gsotldb.php'; 
 
?>    
<center><br/><br/><br/>
                                  
 <form action="smena_prav.php" name="mainform" method="post">
        <label for="dmpost"></label><br/><select name="position">
        <option value="">Выберите какие права дать сотруднику</option>
        <option value="Klad">Старший смены/Кладовщик</option>
        <option value="Logist">Менеджер/Логист/Специалист</option>
        <option value="fin">Финансовая служба</option>
        <option value="kadry">Служба по развитию персонала</option>
        <option value="uvolen">Уволить</option>
                   </center></select>
  <?php


        #echo "Фамилия Имя Отчество (дата рождения) ID";
    echo "<br/>";
    echo "<br/><br/><br/><br/><br/><center><form method='post' action=''>
      <select name='categories'>
      <option value=''> &nbsp&nbsp&nbsp Выберите сотрудника </option>";        
          
$resul =  mysqli_query($link, "select ID, LName, FName, MName, Birthday
            from hb_employee 
            where hb_employee.fUser = '0' and hb_employee.PostID not in (20,0) and 
            hb_employee.ID not in (4192,1415,1560,1737,1237,1239,1240,1241,1521,1242,1243,1238,1244,233,733,232,234,235,498,499,1509,1510,3784,1015,1739,1738,571) or 
            hb_employee.fUser = '1' and  hb_employee.DepartamentID not in (11) and hb_employee.ID not in (3877,3568,3706,3708,3709,3710,3711,3712) 
            ORDER BY hb_employee.LName") 
                or die ("<b>Ошибка подключения:</b>" . mysql_error()); 
 
while ($row = mysqli_fetch_array($resul)){
 
 
echo "<option value=' ".$row['LName']." ".$row['FName']." ".$row['MName']." (".$row['Birthday'].")".$row['ID']." '>".$row['LName']." ".$row['FName']." ".$row['MName']." (".$row['Birthday'].")".$row['ID']."</option>";
}  
   
echo "<input type='submit' value='сменить права' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";    
                                                   
   $dmpost=@$_POST['position'];
   $string=@$_POST['categories'];
   $string_array=explode(")", $string);
   $a=@$string_array[1]-0;  
   #echo $a;
  
  function kurier() {
  include 'gsotldb.php'; 
  global $a, $string;   
  $res =  mysqli_query($link, "Select PostID from hb_employee where hb_employee.ID='$a'");
while ($row = mysqli_fetch_array($res, MYSQL_ASSOC)) 
{
              $kurier=$row["PostID"];
              #echo $kurier;			  
}
  if  (@$kurier ==7 or @$kurier==17 or @$kurier==20 )     { 
  echo "<h2 style=\"color:red;\">Курьера $string переводите через увольнение!</h2>";
  exit;
  }
  }
   if( $dmpost=="Klad" )  {
     kurier();
 /*Action1 */   
   $resul =  mysqli_query($link, "Update hb_employee SET hb_employee.DivisionID='1', hb_employee.DepartamentID='9', hb_employee.PostID='6' 
                         where hb_employee.ID=$a");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='0000000000000000000000000000000000000000000000000000000000000000' where 
                         syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('1','5','6','9','13','17')");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1F00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='2'");   
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1700000000000000000000000000000000000000000000000000000000000000' where 
                         syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('3', '11' )");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1300000303000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('4', '8' )");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1F70000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='7'");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1D00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='10'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1100000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='12'");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1B00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='14'"); 		
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1300000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='15'"); 	
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='0F300007FFFFF000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='0'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1C00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='1'"); 
    						

$res =  mysqli_query($link, "Select hb_employee.PostID from hb_employee where hb_employee.ID=$a");
while ($row = mysqli_fetch_array($res, MYSQL_ASSOC)) 
{
              $change_user=$row["PostID"];
              #echo $del_user;			  
}
if  ($change_user == 6)    {
 
echo "<h2 style=\"color:green;\">Пользователю $string права успешно изменены</h2>"; 
         $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action1', '$Login', '$LogIP', NOW(),
                                                     'Klad ::$string::DivisionID=1 ::DepartamentID=9 ::PostID=6 ::syEmplsRights.crRights=...')");
                        }
		
   } elseif ( $dmpost=="Logist" )
 /*Action2 */    {  kurier();
   $resul =  mysqli_query($link, "Update hb_employee SET hb_employee.DivisionID='1', hb_employee.DepartamentID='2', hb_employee.PostID='8' 
                         where hb_employee.ID=$a");
  $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='0000000000000000000000000000000000000000000000000000000000000000' where 
                         syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('1','9')");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1F00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='2'");   
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1700000000000000000000000000000000000000000000000000000000000000' where 
                         syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('3', '11')");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1300000303000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('4', '8' )");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1100000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('5', '12' )"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1FFF000110000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN ='6'"); 						
						
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1F70000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='7'");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1D00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='10'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1B00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='14'"); 		
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1300000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('15','13')"); 	
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1FF70007FFFFFFFFFF0000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='0'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1C00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='1'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1100000100000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='17'");
    						

$res =  mysqli_query($link, "Select hb_employee.PostID from hb_employee where hb_employee.ID=$a");
while ($row = mysqli_fetch_array($res, MYSQL_ASSOC)) 
{
              $change_user=$row["PostID"];
              #echo $del_user;			  
}
if  ($change_user == 8)    {
 
echo "<h2 style=\"color:green;\">Пользователю $string права успешно изменены</h2>"; 
  $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action2', '$Login', '$LogIP', NOW(),
                                                     'Logist ::$string::DivisionID=1 ::DepartamentID=2 ::PostID=8 ::syEmplsRights.crRights=...')");
                        }
   }
elseif ($dmpost=="fin") {
 /*Action3 */  kurier();  
   $resul =  mysqli_query($link, "Update hb_employee SET hb_employee.DivisionID='1', hb_employee.DepartamentID='19', hb_employee.PostID='8' 
                         where hb_employee.ID=$a");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='0000000000000000000000000000000000000000000000000000000000000000' where 
                         syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('6','9','15','17')");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1FF1000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='1'");   
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1F00000000000000000000000000000000000000000000000000000000000000' where 
                         syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN = '2')");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1700000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('3', '11' )");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1300000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('4', '13' )"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1100000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('5','12')"); 						
						
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1F70000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='7'");  
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1300000303000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='8'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1D00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='10'"); 		
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1B00000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('14')"); 	
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1FF70007FFFFFFFFFF0000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='0'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1C0000000AA00000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='1'"); 
      						

$res =  mysqli_query($link, "Select hb_employee.DepartamentID from hb_employee where hb_employee.ID=$a");
while ($row = mysqli_fetch_array($res, MYSQL_ASSOC)) 
{
              $change_user=$row["DepartamentID"];
              #echo $del_user;			  
}
if  ($change_user == 19)    {
 
echo "<h2 style=\"color:green;\">Пользователю $string права успешно изменены</h2>"; 
   $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action3', '$Login', '$LogIP', NOW(),
                                                     'fin ::$string::DivisionID=1 ::DepartamentID=19 ::PostID=8 ::syEmplsRights.crRights=...')");
                        }
	
          }   elseif ($dmpost=="kadry") {
 /*Action4 */ kurier();		  
	$resul =  mysqli_query($link, "Update hb_employee SET hb_employee.DivisionID='1', hb_employee.DepartamentID='20', hb_employee.PostID='8' 
                         where hb_employee.ID=$a");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='0000000000000000000000000000000000000000000000000000000000000000' where 
                         syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN in ('1','2','3','4','5','6','7','8','10','11','12','13','14','15')");
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1700000303010000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='9'");   
	
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1F70000000000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='0'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1300000FF0000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='16' and syEmplsRights.SubKey='1'"); 
   $resul =  mysqli_query($link, "Update syEmplsRights SET syEmplsRights.crRights='1100000100000000000000000000000000000000000000000000000000000000' where 
                        syEmplsRights.EmplUIN=$a and syEmplsRights.ModuleUIN='17'");  
      						

$res =  mysqli_query($link, "Select hb_employee.DepartamentID from hb_employee where hb_employee.ID=$a");
while ($row = mysqli_fetch_array($res, MYSQL_ASSOC)) 
{
              $change_user=$row["DepartamentID"];
              #echo $del_user;			  
}
if  ($change_user == 20)    {

echo "<h2 style=\"color:green;\">Пользователю $string права успешно изменены</h2>"; 
      $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action4', '$Login', '$LogIP', NOW(),
                                                     'kadry ::$string::DivisionID=1 ::DepartamentID=20 ::PostID=8 ::syEmplsRights.crRights=...')");
                           }		  
			  
		  }
        
        elseif ($dmpost=="uvolen") {
 /*Action5 */			  
	$resul =  mysqli_query($link, "UPDATE hb_employee 
        SET hb_employee.DepartamentID = '0', hb_employee.PostID = '20', hb_employee.fUser = '0', hb_employee.Login = NULL, hb_employee.crPassword = NULL 
        where hb_employee.ID=$a");
        
	$resul =  mysqli_query($link_mto, "Update Employee SET  Employee.DepartamentID = '0', Employee.PostID = '20' where Employee.ID=$a");        
$res =  mysqli_query($link, "Select hb_employee.PostID from hb_employee where hb_employee.ID='$a' ");
while ($row = mysqli_fetch_array($res, MYSQL_ASSOC)) 
{
              $del_user=$row["PostID"];
              #echo $del_user;			  
}
if  (@$del_user == 20) {
  
echo "<h2 style=\"color:green;\">Пользователь $string успешно удален!</h2>";
$res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action5', '$Login', '$LogIP', NOW(),
                                                     'uvolen ::$string::DepartamentID=0 ::PostID=20 ::fUser=0 ::Login=NULL ::crPassword=NULL')");
  $t1=explode(")", $string);
  $t2=explode("(", $string);
  
  $string=iconv("cp1251", "utf-8", $t2[0].$t1[1]);

  
 # echo mb_detect_encoding($string);                        
  echo shell_exec(sprintf("LANG=ru_RU.utf-8; echo $string | mail -s 'uvolen' it@int.dmcorp.ru", escapeshellarg($string))); 
 
                        }  
			  
		  }
          
      ?>
    
</body>
</html>