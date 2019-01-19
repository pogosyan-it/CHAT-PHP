<html>    <title>Изменение адреса ВП</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
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
    width: 200px;
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
<form action="SmenaAdresaVP1.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center" >Добавление или Изменение адреса в ВП</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['SmenaAdresaVP1']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['SmenaAdresaVP1'])){
     header("Location: Menu.php");
     exit;                    }  
     
$region=$_SESSION['Region'];
$change=$_SESSION['change'];

echo "<br/>";

include 'gsotldb.php'; 

 $res =  mysqli_query($link, "Select hbc_divAddr.Name from hbc_divAddr where hbc_divAddr.Name='$region'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $abrev=$row['Name'];
					   }
					    
						mysqli_free_result($res);
 
 $res = mysqli_query($link, "select Addr, Phone from hbc_divAddr where hbc_divAddr.Name='$region'");
 while ($row = mysqli_fetch_assoc($res)){
    $curent=$row['Addr'];
    $tel=$row['Phone'];
}
  #echo  $curent;
      echo "<h2 style=\"color:#B40404;\">Красным выделены обязательные поля для заполнения!";
echo "<br/><br/>";  
if ( !empty($abrev) ) {
     echo "<h2 style=\"color:green;\">$change адрес в регионе <font color='red'>$region<font color='green'>:</font> <font color='#6A5ACD'>$curent<font color='green'> Тел:</font><font color='#6A5ACD'>$tel</font>";  
   } 
   else 
   { echo "<h2 style=\"color:green;\">$change адрес в регионе <font color='red'>$region<font color='green'>:</font> <font color='#6A5ACD'>отсутствует<font color='green'> </font>";  
   }
    
?>  

<table>
    <tr>
        <td> <center><form action="SmenaAdresaVP2.php" name="mainform" method="post"
		<br/> <label for="street"><center><font size="4" color="red"><b>Адрес</b></font></label>    
               <br/><br/><input type="text" name="street" size="21"><br/>  </td>
      
        <td></select>
  <?php 
                      
   echo "<br/>";
   echo "<h2 style=\"color:red;\"><center><font size=\"4\">Тип</font>";
   echo "<br/><center><form method='post' action=''>
      <br/><select name='street_pref'>
      <option value=''>Выберите тип</option>";     
	  
      
$res_pref =  mysqli_query($link, "Select hbc_stritpref.Full from hbc_stritpref where hbc_stritpref.ID not in (0) order by Full") ;                 
 
while ($row = mysqli_fetch_assoc($res_pref)){
 

echo "<option value='".$row['Full']."'>".$row['Full']." </option>";

} 
   ?>
                   </select></td>
        <td><?php 

   echo "<br/>";
   echo "<center>Суффикс";
   echo "<br/><center><form method='post' action=''>
      <br/><select name='street_suf'>
      <option value=''>Выберите Суффикс</option>";     
	  
      
$res_suf =  mysqli_query($link, "Select hbc_stritsuf.Name from hbc_stritsuf") ;                 
 
while ($row = mysqli_fetch_assoc($res_suf)){
 

echo "<option value='".$row['Name']."'>".$row['Name']." </option>";

}?>
    </td>
    <td>
       <label for="phone"><center><font size="4">Телефон</font></label> 
                    <center><br/><input type="text" name="phone" size="20"></td><br/>
                 
   </td>
            <td>
       <label for="office"><center><font size="4">Офис</font></label> 
                    <center><br/><input type="text" name="office" size="4"></td><br/>
                 
   </td>
    </tr>
    <tr>
        <td><label for="home"><center><font size="4" color="red"><b>№ дома</b</font></label> 
                    <center><br/><input type="text" name="home" size="4"></td><br/>   
        <td><font size="4"><label for="drob"><center>Дробь</font></label><br/>
                    <br/><input type="text" name="drob" size="4"><br/></td>
        <td><font size="4"><label for="corp"><center>Корпус</font></label><br/>
                    <br/><input type="text" name="corp" size="4"><br/></td>
        <td><font size="4"><label for="stroen"><center>Строение</font></label><br/>
                    <br/><input type="text" name="stroen" size="4"><br/></td>
        <td><font size="4"><label for="vlad"><center>Владение</font></label><br/>
                    <br/><input type="text" name="vlad" size="4"><br/></td>
    </tr>
    <tr>
        <td colspan="5"> 
<?php 		
   echo "<br/>";
   echo "<br/>";
echo "<center><input type='submit' value='Изменить/добавить адрес' class='my_button'</input>"; 
echo "</select></form></center>"; 
echo "<br/>";
echo "<br/>";
 ?> 
    </td>
    </tr>
</table>

<?php  

  $str_pref=@$_POST['street_pref'];   // ТИП    
  
    $res =  mysqli_query($link, "Select hbc_stritpref.Name from hbc_stritpref where hbc_stritpref.Full='$str_pref'"); 
					         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
  $pref=$row['Name'];
					   }
					    #echo $pref;
						mysqli_free_result($res);
  $str_suf=@$_POST['street_suf'];     //Суффикс (Большая, малая и т.д.)
  $phone=@$_POST['phone'];          // Телефон
  $street=@$_POST['street'];       //Название Улицы
  $home=@$_POST['home'];           //№ Дома
  $drob=@$_POST['drob'];          //Дробь
  $corp=@$_POST['corp'];         //Корпус
  $stroen=@$_POST['stroen'];     //Строение
  $vlad=@$_POST['vlad'];         // Владение
  $office=@$_POST['office'];       // Офис
  
  if($home)	{
?>
<script type="text/javascript">
<!--
location.replace("SmenaAdresaVP2.php");
//-->
</script>
<noscript>
<meta http-equiv="refresh" content="0; url=SmenaAdresaVP2.php">
</noscript>
<?php
}

  
    if (!empty($str_suf))  
{
$street_full=$street.' '.mb_strtolower($str_suf, 'cp1251').' '.mb_strtolower($pref, 'cp1251');
#$street_full=iconv("windows-1251", "windows-1251", $street_full);
}
  else 
{
$street_full=$street.' '.mb_strtolower($pref, 'cp1251');
#$street_full=iconv("windows-1251", "windows-1251", $street_full);
}


 if (!empty($drob)) {
  $drob1='/'.$drob; }
  
  if (!empty($corp)) {
  $corp1=', корп.'.$corp; }
  
   if (!empty($stroen)) {
  $stroen1=', стр. '.$stroen; }
  
   if (!empty($vlad)) {
  $vlad1=', влад.'.$vlad; }
  
   if (!empty($office)) {
  $office1=', оф./кв. '.$office; }
  
  

 @$Addr=$street_full.', д.'.$home.$drob1.$corp1.$stroen1.$vlad1.$office1;

# echo $Addr;

  if ($_SERVER['REQUEST_METHOD'] == "POST")  {
	  

	if (!empty($street)&&!empty($home)&&!empty($str_pref))     // проверка на заполнение полей

    {
         
	    if ( !empty($abrev) ) { 
/*Action1 */   
          $res =  mysqli_query($link, "SELECT ID from hbc_divisions where hbc_divisions.Name = '$abrev' into @a;");                       
          $res =  mysqli_query($link, "SELECT Name from hbc_divisions where hbc_divisions.Name = '$abrev' into @b;"); 
          $res =  mysqli_query($link, "SELECT Mask from hbc_divisions where hbc_divisions.Name = '$abrev' into @xyu;"); 
          	
         $res =  mysqli_query($link, "Insert into d11_addrs (SY_Adding,SY_Empl,StritPref,Strit,Num,Num2,Corp,Bild,Vlad,Office,Addr)
                                      VALUES (NOW(),'3', (select Name from hbc_stritpref where hbc_stritpref.Full='$str_pref'), 
                                      '$street', '$home', '$drob', '$corp', '$stroen', '$vlad', '$office', '$Addr');"); 
					        
          $res =  mysqli_query($link, "Insert into d80_clients (SY_Adding,SY_Empl,ExDiv,ClType,NikName,FullName)
                                      VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$abrev'), '3', 'Внутренняя почта', 'Внутренняя почта');"); 
					        
      
         $res =  mysqli_query($link, "Insert into d81_client2addr (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,CountryID,CityID,StritPref,Strit,Num,Num2,Corp,Bild,Vlad,Office,AddrStr)
                                      VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$abrev'), 
                                      (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), 
                                      (select CountryID from hbc_divisions where hbc_divisions.Name = '$abrev'), 
                                      (select CityID from hbc_divisions where hbc_divisions.Name = '$abrev'), 
                                      (select Name from hbc_stritpref where hbc_stritpref.Full='$str_pref'), 
                                      '$street', '$home', '$drob', '$corp', '$stroen', '$vlad', '$office', '$Addr');");
                                      
        $res =  mysqli_query($link, "Insert into d82_clpersons (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,SName)
                                     VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$abrev'), 
                                    (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), 'CCC');"); 
					                           
        $res =  mysqli_query($link, "Insert into d83_contacts (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,Caption)
                                   VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$abrev'), 
                                  (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), '$phone');"); 
					                          
        $res =  mysqli_query($link, "Insert into d86_clapc (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,d81ID,d82ID,d83ID)
                                       VALUES (NOW(),'3',(select ID from hbc_divisions where hbc_divisions.Name = '$abrev'), 
                                       (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), 
                                       (SELECT max(id) FROM d81_client2addr where d81_client2addr.SY_Empl = '3'), 
                                       (SELECT max(id) FROM d82_clpersons where d82_clpersons.SY_Empl = '3'), 
                                       (SELECT max(id) FROM d83_contacts where d83_contacts.SY_Empl = '3'));");  
          $res =  mysqli_query($link, "SELECT max(id) FROM d11_addrs where d11_addrs.SY_Empl = '3' into @c;"); 			         
          $res =  mysqli_query($link, "SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3' into @d;"); 					                  
          $res =  mysqli_query($link, "SELECT max(id) FROM d81_client2addr where d81_client2addr.SY_Empl = '3' into @e;"); 			         
          $res =  mysqli_query($link, "SELECT max(id) FROM d82_clpersons where d82_clpersons.SY_Empl = '3' into @f;"); 			                    
          $res =  mysqli_query($link, "SELECT max(id) FROM d83_contacts where d83_contacts.SY_Empl = '3' into @g;");                               
					                                 
          $res =  mysqli_query($link, "UPDATE hbc_divAddr SET hbc_divAddr.Name = @b, hbc_divAddr.Phone = '$phone',
                                       hbc_divAddr.AddrID = @c, hbc_divAddr.d80ID = @d, hbc_divAddr.d81ID = @e, hbc_divAddr.d82ID = @f,
                                       hbc_divAddr.d83ID = @g, hbc_divAddr.Addr = '$Addr', hbc_divAddr.FullName = 'ООО \"ДАЙМЭКС\"', 
                                       hbc_divAddr.Mask = @xyu where hbc_divAddr.Name = '$abrev';"); 
                                       
      $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action1', '$Login', '$LogIP', NOW(),
      '=$abrev ::=$str_pref ::Street=$street ::Num=$home ::Num2=$drob ::Corp=$corp ::Bild=$stroen ::Vlad=$vlad ::Office=$office ::Addr=$Addr ::=$phone')");                                               
                                       
echo "<font color='green'>Адрес <font color='#6A5ACD'>$Addr <font color='green'>тел:<font color='#6A5ACD'>$phone <font color='green'>в регионе <font color='red'>$region <font color='green'>успешно обновлен</font>";       
      $_SESSION['change']='Изменённый';        
      }
       else { 
/*Action2 */					         
          $res =  mysqli_query($link, "SELECT ID from hbc_divisions where hbc_divisions.Name = '$region' into @a;");                       
          $res =  mysqli_query($link, "SELECT Name from hbc_divisions where hbc_divisions.Name = '$region' into @b;"); 
          $res =  mysqli_query($link, "SELECT Mask from hbc_divisions where hbc_divisions.Name = '$region' into @xyu;");

          
         $res =  mysqli_query($link, "Insert into d11_addrs (SY_Adding,SY_Empl,StritPref,Strit,Num,Num2,Corp,Bild,Vlad,Office,Addr)
                                      VALUES (NOW(),'3', (select Name from hbc_stritpref where hbc_stritpref.Full='$str_pref'), 
                                      '$street', '$home', '$drob', '$corp', '$stroen', '$vlad', '$office', '$Addr');"); 
					        
          $res =  mysqli_query($link, "Insert into d80_clients (SY_Adding,SY_Empl,ExDiv,ClType,NikName,FullName)
                                      VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$region'), '3', 'Внутренняя почта', 'Внутренняя почта');"); 
			
         $res =  mysqli_query($link, "Insert into d81_client2addr (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,CountryID,CityID,StritPref,Strit,Num,Num2,Corp,Bild,Vlad,Office,AddrStr)
                                      VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$region'), 
                                      (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), 
                                      (select CountryID from hbc_divisions where hbc_divisions.Name = '$region'), 
                                      (select CityID from hbc_divisions where hbc_divisions.Name = '$region'), 
                                      (select Name from hbc_stritpref where hbc_stritpref.Full='$str_pref'), 
                                      '$street', '$home', '$drob', '$corp', '$stroen', '$vlad', '$office', '$Addr');");
                                      
        $res =  mysqli_query($link, "Insert into d82_clpersons (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,SName)
                                     VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$region'), 
                                    (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), 'CCC');"); 
					                           
      $res =  mysqli_query($link, "Insert into d83_contacts (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,Caption)
                                   VALUES (NOW(),'3', (select ID from hbc_divisions where hbc_divisions.Name = '$region'), 
                                  (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), '$phone');"); 
					                          
      $res =  mysqli_query($link, "Insert into d86_clapc (SY_Adding,SY_Empl,SY_OwnDiv,d80ID,d81ID,d82ID,d83ID)
                                       VALUES (NOW(),'3',(select ID from hbc_divisions where hbc_divisions.Name = '$region'), 
                                       (SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3'), 
                                       (SELECT max(id) FROM d81_client2addr where d81_client2addr.SY_Empl = '3'), 
                                       (SELECT max(id) FROM d82_clpersons where d82_clpersons.SY_Empl = '3'), 
                                       (SELECT max(id) FROM d83_contacts where d83_contacts.SY_Empl = '3'));"); 
          
          $res =  mysqli_query($link, "SELECT max(id) FROM d11_addrs where d11_addrs.SY_Empl = '3' into @c;"); 			         
          $res =  mysqli_query($link, "SELECT max(id) FROM d80_clients where d80_clients.SY_Empl = '3' into @d;"); 					                  
          $res =  mysqli_query($link, "SELECT max(id) FROM d81_client2addr where d81_client2addr.SY_Empl = '3' into @e;"); 			         
          $res =  mysqli_query($link, "SELECT max(id) FROM d82_clpersons where d82_clpersons.SY_Empl = '3' into @f;"); 			                    
          $res =  mysqli_query($link, "SELECT max(id) FROM d83_contacts where d83_contacts.SY_Empl = '3' into @g;");                                  
					                                 
          $res =  mysqli_query($link, "Insert into hbc_divAddr (ID,Name,Phone,AddrID,d80ID,d81ID,d82ID,d83ID,Addr,FullName,Mask)
                                       VALUES (@a, @b, '$phone', @c, @d, @e, @f, @g, '$Addr', 'ООО \"ДАЙМЭКС\"', @xyu);");  
                                       
          $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action2', '$Login', '$LogIP', NOW(),
      '=$region ::=$str_pref ::Street=$street ::Num=$home ::Num2=$drob ::Corp=$corp ::Bild=$stroen ::Vlad=$vlad ::Office=$office ::Addr=$Addr ::=$phone')");                             
                                                         
echo "<font color='green'>Адрес <font color='#6A5ACD'>$Addr <font color='green'>тел:<font color='#6A5ACD'>$phone <font color='green'>в регионе <font color='red'>$region <font color='green'>успешно добавлен</font>";       
      $_SESSION['change']='Новый';                                         
                                       }
	}
	else {                                                                                                    
	echo "<h2 style=\"color:red;\">Заполните необходимые поля</h2>";
 $_SESSION['change']='Текущий'; 
}
  
  }
   
?>
</body>
</html>