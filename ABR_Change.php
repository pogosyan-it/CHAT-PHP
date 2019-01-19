<html>  <title>Изменение схемы отправок</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="chekbox.css"  type="text/css">
 <style type="text/css">  
 body{ text-align: center;  background-image: url(yellow-specks.png);}
label{display: block; float: left; width: 150px;
  padding: 0 10px; margin: 18px 0 0; text-align: right;}
table { margin-left: 20%; }

.my_button {
    width: 220px;
    height: 40px;
border-radius: 55px; box-shadow: 1px 1px 3px; font-size: 16px
}
  </style> 
 <?php  
include 'profilaktika.php'; 
?>
 </head>
<body>

<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form>      
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center">Изменение схемы отправок</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['ABR_Change']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['ABR_Change'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'gsotldb.php';
 
$index=0; 
$res =  mysqli_query($link, "Select hbc_cities.Name, hbc_rChange.Region_abr from hbc_rChange  left join hbc_cities on hbc_cities.ID=hbc_rChange.id_city_adr ");
                      ?> <table border=2px width=500px align=left text-align=left  >  <tr>
                                          <td colspan="3"><center><b>Текущая схема</b> </td>  </tr>
                                        <tr>  <td><center><b>Город назначения</b></td>
                                              <td><center><b>Регион получения</b></td>
                                              <td><center><b>Удаление</b></td> 
                                        </tr> 
                                        <form method='post'>  
<?php  
  while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {            
                              $index++;                                                          
                              ?>   
                                     <tr>
                                            <td><?php echo $row[0] ?></td>
                                            <td><?php echo $row[1] ?> </td>
   <td><input type="checkbox" class="checkbox" id="<?php echo $row[0] ?>" name="chb[]" value="<?php echo $row[0] ?>" /> <label for="<?php echo $row[0] ?>">  </label> </td>                                             
                                     </tr>       
                                                                                       
                                 <?php  $index=0;
                                   if(isset($_POST['submit']))
{     
     foreach ($_POST['chb'] as $value)
         switch ($value) {
             case "$row[0]":
/*Action1 */ 
             $res1 =  mysqli_query($link, "delete hbc_rChange from hbc_rChange left join hbc_cities on hbc_cities.ID=hbc_rChange.id_city_adr where hbc_cities.Name='$row[0]'");
             if  ($res1 == 'true') {   
                   $res2 =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action1', '$Login', '$LogIP', NOW(),
'delete hbc_rChange ::hbc_cities.Name=$row[0]')");}
             break;  
         } 
      print'<meta http-equiv="refresh" content="0;ABR_Change.php">';      
}            
                 }                
?>          
<td colspan=3><center> <input type='submit' name="submit" value='Удалить выбранные' class="my_button">          </form></td>           </table>      
              
 <table border=1px width=500px align=center >
    <tr>  <td>                                           
     <?php 

echo "<center><b>Город назначения</b>";
echo "<br/>"; 
echo "<br/><center><form method='post' action=''>
      <select name='CityID'>
      <option value=''> Выберете город назначения </option>";   
	                                               
$res_pref =  mysqli_query($link, "select hbc_divisions.CityID, hbc_divisions.Name, hbc_cities.Name as City  from hbc_divisions 
                                  left join hbc_cities on hbc_cities.ID=hbc_divisions.CityID 
                                  where hbc_divisions.ParentID != hbc_divisions.ID and hbc_cities.Name  IS NOT NULL order by hbc_divisions.Name");                 
while ($row = mysqli_fetch_assoc($res_pref)){
echo "<option value='".$row['CityID'].")".$row['City']."'>".$row['Name']." </option>";
                                            }     ?>     </td>
                                                     <td>     
       <?php  
echo "<center><b>Регион получения</b>";
echo "<br/>"; 
echo "<br/><center><form method='post' action=''>
      <select name='DivID'>
      <option value=''> Выберете регион получения </option>";   
	                                               
$res_pref =  mysqli_query($link, "select  Name, ID as DivID from hbc_divisions where hbc_divisions.ParentID = hbc_divisions.ID order by Name");                 
while ($row = mysqli_fetch_assoc($res_pref)){            
echo "<option value='".$row['DivID'].")".$row['Name']."'>".$row['Name']." </option>";
                                            } 
 ?>     
  </td>  </tr>
   <td colspan="2">
<form method='post' action=''>     
 <center> <input type="submit" name="run" value='Добавить' class="my_button">
  </form> </td>
<tr>  <td colspan="2">
 <?php
 if (isset($_SESSION['addabr']))   {
 echo @$_SESSION['addabr'];
?> </td></tr></table>  <?php
 unset($_SESSION['addabr']); }
 $CityID=explode(")", @$_POST['CityID']);
 @$CityName=$CityID[1];
$CityID=$CityID[0]; 
$DivID=explode(")", @$_POST['DivID']);
@$DivName=$DivID[1];
$DivID=$DivID[0]; 
 if (@$_POST['run']) { 
 if  (empty ($CityID) or empty ($DivID)) {$_SESSION['addabr']= "<h3 style=\"color:red;\">Не выбраны значения</h3>";
 print'<meta http-equiv="refresh" content="0;ABR_Change.php">'; }
 else {
$view_db = mysqli_query($link, "Select * from hbc_rChange where id_city_adr='$CityID'"); 
    $row_num = mysqli_num_rows($view_db);
/*Action2 */         
 if   ($row_num==0) {    $resul =  mysqli_query($link, "Insert into hbc_rChange VALUES(DEFAULT, '$CityID', '$DivID', '$DivName' )"); 
 if (mysqli_affected_rows($link)==1) {
 $res2 =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action2', '$Login', '$LogIP', NOW(),
'Insert hbc_rChange ::CityName=$CityName ::DivID=$DivID ::DivName=$DivName')");
   $_SESSION['addabr'] = "<h3 style=\"color:green;\">Город назначения \"$CityName\" и регион назначения \"$DivName\"  успешно добавлены</h3>";  
  print'<meta http-equiv="refresh" content="0;ABR_Change.php">';      
                                     }
 else {echo "Ошибка при добавлении";}     
                    }
                   else {       print'<meta http-equiv="refresh" content="0;ABR_Change.php">';
                         $_SESSION['addabr']= "<h3 style=\"color:red;\">Город назначения \"$CityName\" уже существует</h3>";  } 
      }                 }        

  ?>
  
</body>
</html>
