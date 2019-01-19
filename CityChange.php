<html>    <title>Изменение НП РФ</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
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
    width: 180px;
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
   <h3><div align="center" >Изменение НП РФ</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['CityChange']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['CityChange'])){
     header("Location: Menu.php");
     exit;                    }  
 
   include 'gsotldb.php';
      
 echo "<br/><center><form method='post' action=''>
      <select name='categories'>
      <option value=''> Выберите область </option>";        
          
$result =  mysqli_query ($link, "select ID, Name from hbc_fedunits order by Name"); 
while ($row = mysqli_fetch_assoc($result)){ 
echo "<option value='".$row['ID']."'>".$row['Name']." </option>";
}           ?> 
 <form method='post'>  
<center><br /> <input type="submit" name="run" value='Выбрать' class="my_button">  </form> 

 <?php 
echo "<br/>";
  
if (@$_POST['run'])   {      $_SESSION['Obl']=@$_POST['categories'];        }
  
$obl= $_SESSION['Obl'];
  $res =  mysqli_query($link, "select Name from hbc_fedunits where ID='$obl'");               
 while ($row = mysqli_fetch_assoc($res)){
 $oblname=$row['Name'];
   }
  echo "<font size='4'>Выбранная область: <font color='red'>$oblname</font>"; 
 ?>  
<br/> <br/> 
<form action="Examples\CityChange_EX.php" method="post">     
<input type="submit" name="runex" value='Выгрузить в Excel' class="my_button">
  </form>
<table>  
    <tr>
    <td colspan="2"> 
  <?php 
   echo "<br/>";
   echo "<center>Населённый пункт РФ";
   echo "<br/><center><form method='post' action=''>
      <br/><select name='city'>
      <option value=''>Выберите населённый пункт</option>";       
     
$city =  mysqli_query($link, "select hbc_cities.ID, hbc_cities.Name as city, hbc_routes.Name as route, hbc_fedunittypes.Name as city_type, hbc_zones.Name as zname
from hbc_cities
left join hbc_fedunittypes on hbc_cities.UnitTypeID=hbc_fedunittypes.ID
left join hbc_routes on hbc_routes.ID=hbc_cities.RouteUIN
left join hbc_zones on hbc_zones.ID=hbc_cities.ZoneID
where hbc_cities.CountryID = '7' and hbc_cities.FedUnitID=$obl and hbc_cities.Name not like 'DELETE%' ORDER BY hbc_cities.Name") ;                 
    
while ($row = mysqli_fetch_assoc($city)){
 #$cityID=$row['citiID'];
echo "<option value='".$row['ID']."'>".$row['city']." [".$row['route']."] ".$row['city_type']." {".$row['zname']."}</option>";
 }
?>
    </td>
          <td>
       <?php 
   #echo "<br/>";
   echo "<center>Выберите тип НП";
    echo "<br/><center><form method='post' action=''>
      <br/><select name='type'>
      <option value=''>Не менять тип</option>";   
	                                               
$resul =  mysqli_query($link, "select ID, Name from hbc_fedunittypes order by Name");            
 while ($row = mysqli_fetch_assoc($resul)){
 
echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
}
?>
   </td>
             <td>Удалить маршрут:  <br/>
           <center>  <input type="checkbox" name="rout" value="Yes" />
       <?php 
    echo "<br/><center><form method='post' action=''>
      <br/><select name='route'>
      <option value=''>Не менять маршрут</option>";   
	                                               
$resul =  mysqli_query($link, "select ID, Name from hbc_routes where hbc_routes.SY_Void ='0' and hbc_routes.ID not in (128,201,202,203,204,205,206,207,208,209,210,211,231,244,232,243,304) order by Name");            
 while ($row = mysqli_fetch_assoc($resul)){
 
echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
}
?>
   </td>    </tr>
    <tr>    <td> <center><form action="CityChange.php" name="mainform" method="post"<br/>
  	<label for="newName"><font  color="black">Новое название НП</font></label> 
               <br/><br/><input type="text" name="newName" size="40">   
    </td> 
    <td>  
 <?php 
    echo "<center>Выберите Зону";
     echo "<br/>";
   echo "<br/><center><form method='post' action=''>
      <select name='zones'>
      <option value=''> Не менять зону </option>";   
	                                               
$resul =  mysqli_query($link, "select Name from hbc_zones");
               
 while ($row = mysqli_fetch_assoc($resul)){
  
echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

}
?>    
     </td> 
        <td colspan="3"> 
<?php 		
  
   echo "<br/>"; ?>   <form method='post'>  
<center><br /> <input type="submit" name="run1" value='Изменить' class="my_button">  </form>
           <?php   
echo "<br/>";
echo "<br/>";
 ?> 
    </td>
    </tr>
</table>
  <?php 
   if (isset($_SESSION['nevibran']))   {
 echo @$_SESSION['nevibran'];
 unset($_SESSION['nevibran']); }
   if (isset($_SESSION['result']))   {
   echo @$_SESSION['result'];
 unset($_SESSION['result']); }
 if (@$_POST['run1'])  { 
  $cityID=@$_POST['city'];  
  $newName=@$_POST['newName'];  
    //отбираем название города 
  $res =  mysqli_query($link, "select Name, UnitTypeID, RouteUIN, ZoneID, ExDivUIN from hbc_cities where hbc_cities.ID='$cityID'");              
 while ($row = mysqli_fetch_assoc($res)){
  $city=$row['Name'];
  $UnitTypeID=$row['UnitTypeID'];
  $RouteUIN=$row['RouteUIN'];
  $ExDivUIN=$row['ExDivUIN'];
  $zoneOld=$row['ZoneID'];
   }
$res =  mysqli_query($link, "select Name from hbc_fedunittypes where ID='$UnitTypeID'");              
 while ($row = mysqli_fetch_assoc($res)){ $OldUnitTypeID=$row['Name']; }
 $res =  mysqli_query($link, "select Name from hbc_routes where ID='$RouteUIN'");              
 while ($row = mysqli_fetch_assoc($res)){ $OldRouteUIN=$row['Name']; }
    
 #  if (empty($newName))  {$newName=$city;}  
    $type=@$_POST['type'];  
 if (empty($type))  {$type=$UnitTypeID;}
 $res =  mysqli_query($link, "select Name from hbc_fedunittypes where ID='$type'");               
 while ($row = mysqli_fetch_assoc($res)){
 $Rtype=$row['Name'];
   }
  if ($_POST['rout'] == 'Yes')  {                         //галочка удалить маршрут
     $route=0;
   $ExDivUIN=0;
   $Rname='без маршрута';         }
   else if (empty(@$_POST['route']))   {                 //не менять маршрут
  $route=$RouteUIN;    
   $res =  mysqli_query($link, "select Name as Rname from hbc_routes where hbc_routes.ID='$route'");              
 while ($row = mysqli_fetch_assoc($res)){
 $Rname=$row['Rname'];
  $OldRouteUIN=$row['Rname'];
   }   
   if  ($RouteUIN=='0')    {$Rname='без маршрута'; $OldRouteUIN='без маршрута';}
                                 }
     else
  {
    $route=@$_POST['route'];       //новый маршрут
    $ExDivUIN=1;
    $res =  mysqli_query($link, "select Name as Rname from hbc_routes where hbc_routes.ID='$route'");
               
 while ($row = mysqli_fetch_assoc($res)){
 $Rname=$row['Rname'];
   }
    if  ($RouteUIN=='0')    { $OldRouteUIN='без маршрута';}
  }
    $zone=@$_POST['zones'];         //проверка на зоны
    $NewzoneName=$zone;
    $res =  mysqli_query($link, "select distinct hbc_zones.Name from hbc_cities left join hbc_zones on hbc_zones.ID=hbc_cities.ZoneID where hbc_cities.ZoneID='$zoneOld'");              
 while ($row = mysqli_fetch_assoc($res)){
 $ZoldName=$row['Name'];
                                        }
 if (empty($zone))  {$zone=$zoneOld;  $NewzoneName=$ZoldName;
                    } 
                    else {   
$res =  mysqli_query($link, "select distinct  hbc_zones.ID from hbc_cities left join hbc_zones on hbc_zones.ID=hbc_cities.ZoneID where hbc_zones.Name='$zone'");              
 while ($row = mysqli_fetch_assoc($res)){
 $zone=$row['ID'];}     }
   
	    if (!empty ($cityID))     // проверка на заполнение полей
      {
    if (empty($newName))  {$newName=$city;}  
    else
           {
 $res =  mysqli_query($link, "Select hbc_cities.Name,  hbc_fedunittypes.Name  as Тип, hbc_routes.Name as Маршрут
                              from hbc_cities
                              left join hbc_fedunits on hbc_cities.FedUnitID=hbc_fedunits.ID
                              left join hbc_routes on hbc_cities.RouteUIN=hbc_routes.ID
                              left join hbc_fedunittypes on hbc_cities.UnitTypeID=hbc_fedunittypes.ID
                              where hbc_cities.Name='$newName' and FedUnitID='$obl'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					                              {
						   $city_base=$row['Name']; 
               $type=$row['Тип'];  
                $route=$row['Маршрут']; 
                                       }   
# if (strcasecmp($newName, $city_base) == 0)
if ( strcasecmp(mb_strtolower(@$city_base), mb_strtolower($newName)) == 0 )             //Проверка на существование в базе
						   {
							  #   echo "<h2 style=\"color:red;\">Населенный пункт $newName в $obl уже есть</h2>";
$_SESSION['result']= "<font color='red' size='4'>$type <font color='red'>\"$newName\" <font color='green'>с маршрутом <font color='red'>$OldRouteUIN
 <font color='green'>в <font color='red'>$oblname <font color='green'>уже есть</font>";                                                                                                                       

      print'<meta http-equiv="refresh" content="0;CityChange.php">';
					exit;
          	   }      
          }   

/*Action */       
   $query = mysqli_query($link, "Update hbc_cities SET Name='$newName', UnitTypeID='$type', RouteUIN='$route', ZoneID='$zone', ExDivUIN='$ExDivUIN' where ID='$cityID'");
                if  ($query == 'true') {                                         
 $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(), 'OldName=$city ::NewName=$newName ::OldUnitTypeID=$OldUnitTypeID
 ::NewUnitTypeID=$Rtype ::OldRouteUIN=$OldRouteUIN ::NewRouteUIN=$Rname ::OldZone=$ZoldName ::NewZone=$NewzoneName ::ExDivUIN=$ExDivUIN')");  
                                            
              #  echo "<script>window.location.href='CityChange2.php'</script>";     // обновляем страницу   
 $_SESSION['result']= "<font color='green' size='4'>Старое название:<font color='#6A5ACD'>$city <font color='green'>Новое название:<font color='#6A5ACD'>$newName
  <font color='green'>Старый тип:<font color='#6A5ACD'>$OldUnitTypeID <font color='green'>Новый тип:<font color='#6A5ACD'>$Rtype
  <font color='green'>Старый маршрут:<font color='#6A5ACD'>$OldRouteUIN <font color='green'>Новый маршрут:<font color='#6A5ACD'>$Rname</font> 
  <font color='green'>Старая зона:<font color='#6A5ACD'>$ZoldName <font color='green'>Новая зона:<font color='#6A5ACD'>$NewzoneName</font>";                                                                                                                        
	
      print'<meta http-equiv="refresh" content="0;CityChange.php">';
        }
    else
    {
    echo "<h2 style=\"color:red;\">Произошла ошибка при изменении маршрута!</h2>";
    }                
		  }
        else {
	               $_SESSION['nevibran']="<h2 style=\"color:red;\">Выберите населенный пункт</h2>";
                  print'<meta http-equiv="refresh" content="0;CityChange.php">';
             }		 
                     }   
   ?>
</body>
</html>