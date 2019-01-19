<html>    <title>Выдача и приём одежды</title>
<head>   <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
  <link rel="stylesheet" href="tcal.css"> 
 <style type="text/css">
   table {
    width: 300px; /* Ширина таблицы */
    margin: auto; /* Выравниваем таблицу по центру окна  */
   }
   .my_button {
    width: 190px;
    height: 40px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}
.my_button1 {
    width: 190px;
    height: 40px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px;  background:#7FFF00;
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
   
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['mto']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }
if(!isset($_SESSION['mto'])){
     header("Location: Menu.php");
     exit;                    }         

   include 'mtoldb.php';
   
if (!$link_mto) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());  
   exit; 
}  
  if (isset($_SESSION['noname'])) 
  { 
  ?>
<div id="errorchl"><font size="6" color="red">Не выбран сотрудник!</font></div>          
            <?php
  unset($_SESSION['noname']);   
 }
  else 
  {
  unset($_SESSION['noname']);
 } 
  if (isset($_SESSION['nodate'])) 
  { 
  ?>
<div id="errorchl"><font size="6" color="red">Не выбрана дата</font></div>          
            <?php
  unset($_SESSION['nodate']);   
 }
  else 
  {
  unset($_SESSION['nodate']);
 }  
 
?>  
 <h3><div align="center" >Выдача и приём одежды</div></h3>

<table cellspacing="1" border="1">
    <tr>
        <td colspan="2"> </select><form action="mto.php" method="post">  
  <?php 
                      
   echo "<h2 style=\"color:black;\"><center><font size=\"4\">ФИО Сотрудника:</font>";
   echo "<center><form method='post' action=''>
      <select name='FIO'>
      <option value=''>Выберите ФИО</option>";     
	        
$res_pref =  mysqli_query($link_mto, "Select ID,  SName from Employee where Employee.SName not in ('Admin', 'DIMEX - УК ....' ) order by Employee.SName;") ;                 
while ($row = mysqli_fetch_assoc($res_pref)){
echo "<option value='".$row['ID']."'>".$row['SName']." </option>";
}     
   ?>
                   </select></td>
        <td>
  <?php 
                      
   echo "<h2 style=\"color:black;\"><center><font size=\"4\">Размер и рост:</font>";
   echo "<center><form method='post' action=''>
      <select name='size'>
      <option value=''>Выберите размер и рост</option>";       
      
$res_pref =  mysqli_query($link_mto, "Select ID, size, height from Size;") ;                  
while ($row = mysqli_fetch_assoc($res_pref)){
echo "<option value='".$row['ID']."'>".$row['size']." (".$row['height'].") </option>";  
}    $date=date("Y-m-d H:i:s");
   ?>
                   </select></td>
                <script type="text/javascript" src="tcal.js"></script> 
             <td>   <center><h2> <font  size="4">Дата</font>   </h2>  
   <div><input type="text" name="date" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value= <?php echo "$date"; ?>  /></div>                                                                  

  </center>
            </td>
     </tr>
        <td >
       
                        <?php 
                                            
                         echo "<h2 style=\"color:black;\"><center><font size=\"4\">Наименование:</font>";
                         echo "<center><form method='post' action=''>
                            <select name='clothes1'>
                            <option value=''>Выберите Наименование</option>";     
                           
             $res_pref =  mysqli_query($link_mto, "Select ID, Name from Item") ;                 
         while ($row = mysqli_fetch_assoc($res_pref)){
                echo "<option value='".$row['ID']."'>".$row['Name']." </option>";
                    } 
                         ?>
                   </select>
        </td>
   <td colspan="2" ><center>  <label for="Day">Количество:</label>
<input type="text" name="amount1" size="5" maxlength="3" placeholder=1 >
       </td>
       <td colspan="2" ><center>  <label for="wearout">% износа:</label>
             <input type="text" name="wearout1" size="5" maxlength="3" > 
       </td>
    </tr> 
         <tr>
        <td>
        
                        <?php 
                                            
                         echo "<h2 style=\"color:black;\"><center><font size=\"4\">Наименование:</font>";
                         echo "<center><form method='post' action=''>
                            <select name='clothes2'>
                            <option value=''>Выберите Наименование</option>";     
                            
                      $res_pref =  mysqli_query($link_mto, "Select ID, Name from Item") ;                 
                    while ($row = mysqli_fetch_assoc($res_pref)){
                    echo "<option value='".$row['ID']."'>".$row['Name']." </option>";
                     } 
                         ?>
                   </select></td>
       <td colspan="2" ><center>  <label for="Day">Количество:</label>  
             <input type="text" name="amount2" size="5" maxlength="3" placeholder=1> 
       </td>
      <td colspan="2" ><center>  <label for="wearout">% износа:</label>
             <input type="text" name="wearout2" size="5" maxlength="3" > 
       </td>
    </tr>
    <tr>
        <td  >       
                        <?php 
                                            
                         echo "<h2 style=\"color:black;\"><center><font size=\"4\">Наименование:</font>";
                         echo "<center><form method='post' action=''>
                            <select name='clothes3'>
                            <option value=''>Выберите Наименование</option>";     
                           
                      $res_pref =  mysqli_query($link_mto, "Select ID, Name from Item") ;                 
                     while ($row = mysqli_fetch_assoc($res_pref)){
                     echo "<option value='".$row['ID']."'>".$row['Name']." </option>";
                     } 
                         ?>
                   </select></td>
       <td colspan="2" ><center><label for="Day">Количество:</label>
      <input type="text" name="amount3" size="5" maxlength="3" placeholder=1> 
       </td>
      <td colspan="2" ><center>  <label for="wearout">% износа:</label>
             <input type="text" name="wearout3" size="5" maxlength="3" > 
       </td>
    </tr>     
</table>
    <br/>
 <table  cellpadding="10" >
 <tr>
<td>
<center> <input name="give" type="submit" value="Выдать чуваку" class="my_button1">    
 <br />

    </td> 
  <td> 
<center> <input name="priem" type="submit" value="Принять у чувака" class="my_button">    
 <br />  
    </td>
         <td>
         <center> <input name="nabalanse" type="submit" value="Числиться на чуваках" class="my_button">    
 <br /> 

    </td> </tr> 
    </table>  <tr>
    <table  cellpadding="10" >
             <td colspan="2" >
<center> <input name="nasklad" type="submit" value="Принять на склад" class="my_button">    
 <br />  
    </td>
    <td>  
<center> <input name="sklad" type="submit" value="Остаток на складе" class="my_button">    
 <br /> 
    </td>
 <td>  
<center> <input name="giveEX" type="submit" value="Выдача за день" class="my_button">    
 <br /> </form> 
    </td>    
    </tr>

</table>
<?php  
  $name_id=@$_POST['FIO'];        
  $size_id=@$_POST['size'];
  $Newsize_id=$size_id;
  $date1=@$_POST['date'];
  $date=$date1.date(" H:i:s"); 

  $Item_id_1=@$_POST['clothes1'];
  $Item_id_2=@$_POST['clothes2'];
  $Item_id_3=@$_POST['clothes3'];
  
  $quantity_1=@$_POST['amount1'];
  $quantity_2=@$_POST['amount2'];
  $quantity_3=@$_POST['amount3'];
  $wearout1=@$_POST['wearout1'];
  $wearout2=@$_POST['wearout2'];
  $wearout3=@$_POST['wearout3'];
  if (empty ($Item_id_1)){$Item_id_1='10';}
  if (empty ($Item_id_2)){$Item_id_2='11';}
  if (empty ($Item_id_3)){$Item_id_3='12';}  
  
if ($Item_id_1==$Item_id_2 or $Item_id_2==$Item_id_3 or $Item_id_1==$Item_id_3) { echo "<h2 style=\"color:red;\">Выбрано одинаковое наименование</h2>"; exit;}    
  
if (empty ($quantity_1)){$quantity_1=1;}
if (empty ($quantity_2)){$quantity_2=1;}  
if (empty ($quantity_3)){$quantity_3=1;}
     
#echo "name_id=$name_id, date=$date, size_id=$size_id, Item_id_1=$Item_id_1, Item_id_2=$Item_id_2,  Item_id_3=$Item_id_3, quantity_1=$quantity_1, quantity_2=$quantity_2, quantity_3=$quantity_3"; 

function give($Item_id, $quantity){           // Выдача сотруднику
global $Item_id_1, $quantity_1, $name_id, $size_id, $date, $link_mto, $Newsize_id;
 if   (empty($name_id))  { echo "<h2 style=\"color:red;\">Не выбран сотрудник</h2>";  exit;}
# if  (preg_match("/[5-8]/", $Item_id)) {$size_id='';}
         if ($Item_id!='10' xor     $Item_id!='11' xor   $Item_id!='12') {  
        if ( $Item_id<5) {$size_id=$Newsize_id;}  
           else { $size_id=0; }        
    $res1 =  mysqli_query($link_mto, "Select quantity from Warehouse where id_item='$Item_id' and id_size='$size_id'; ");
          while ($row = mysqli_fetch_array($res1, MYSQLI_ASSOC))
					   {
						   $kol=$row['quantity'];            
						 }
     
             $res =  mysqli_query($link_mto, "select Name from Item where ID='$Item_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $Item_Name=$row['Name'];            
						 }
           
             if ($kol<$quantity) {              
             $res =  mysqli_query($link_mto, "select size, height from Size where ID='$size_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $size=$row['size'];
               $height=$row['height'];
                       
						 }         
             if (!isset ($_SESSION['NoKol1']))  {$_SESSION['NoKol1'] = "<h2 style=\"color:red;\">Недостаточно $Item_Name $size $height на складе для выдачи</h2>";}
             elseif  (!isset ($_SESSION['NoKol2'])) {$_SESSION['NoKol2'] = "<h2 style=\"color:red;\">Недостаточно $Item_Name $size $height на складе для выдачи</h2>";}
             else {$_SESSION['NoKol3'] = "<h2 style=\"color:red;\">Недостаточно $Item_Name $size $height на складе для выдачи</h2>";}
                              }
             else {
              $quantity1=$kol-$quantity;
           
              $res11 =  mysqli_query($link_mto, "select quantity from `Empl_hand-out` where Emp_id='$name_id' and id_item='$Item_id' and id_size='$size_id'");  
                                         while ($row = mysqli_fetch_array($res11, MYSQLI_ASSOC))
		                     	{ $KolBalans=$row['quantity'];   }  
                   if ($KolBalans==0)   {$res3 =  mysqli_query($link_mto, "Insert into `Empl_hand-out` values (DEFAULT, '$name_id', '$Item_id', '$size_id', '$date', '$quantity'); ");}   
                   else {$KolNewBalans=$quantity+$KolBalans; 
          $res3 =  mysqli_query($link_mto, "UPDATE `Empl_hand-out` set quantity='$KolNewBalans' where Emp_id='$name_id' and id_item='$Item_id' and id_size='$size_id'; ");} 
            
               }
           $res2 =  mysqli_query($link_mto, "UPDATE Warehouse set Warehouse.quantity='$quantity1' where Warehouse.id_item='$Item_id' and Warehouse.id_size='$size_id'; ");
             
           if  ($res2 == 'true' and $res3 == 'true')   {
            $res =  mysqli_query($link_mto, "select SName from Employee where ID='$name_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $SName=$row['SName'];
              $_SESSION['SName'] = $SName;              
						 }
             
             $res =  mysqli_query($link_mto, "select size, height from Size where ID='$size_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $size=$row['size'];
               $height=$row['height'];
               $_SESSION['size']=$size;
               $_SESSION['height']=$height;             
						 }
             if (!isset ($_SESSION['Item_id_1']))  {$_SESSION['Item_id_1'] = $Item_Name; $_SESSION['quantity_1']=$quantity;  }
             elseif  (!isset ($_SESSION['Item_id_2'])) {$_SESSION['Item_id_2'] = $Item_Name; $_SESSION['quantity_2']=$quantity; }
             else {$_SESSION['Item_id_3'] = $Item_Name; $_SESSION['quantity_3']=$quantity; } 
             
             if  (preg_match("/[1-4]/", $Item_id)){
            echo "<h2 style=\"color:green;\">Успешно выдано $SName, $Item_Name, размер:$size $height, количесто:$quantity, $date </h2>"; }
            else  {echo "<h2 style=\"color:green;\">Успешно выдано $SName, $Item_Name, количесто:$quantity, $date </h2>"; }
             }          }   }
                                    
                                    
function priem($Item_id, $quantity, $wearout){      // Принятие у сотрудника
global $Item_id_1, $name_id, $size_id, $date, $link_mto, $Newsize_id; 
 if   (empty($name_id)  )  { echo "<h2 style=\"color:red;\">Не выбран сотрудник</h2>";  exit;}
 if ($Item_id!='10' xor     $Item_id!='11' xor   $Item_id!='12') {
  if ( $Item_id<5) {$size_id=$Newsize_id;} 
            else { $size_id=0; }
 $res = mysqli_query($link_mto, "select quantity from `Empl_hand-out` where Emp_id='$name_id' and id_item='$Item_id' and id_size='$size_id'");
           while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $kol=$row['quantity'];
						 }
             $res = mysqli_query($link_mto, "select Name from Item where ID='$Item_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $Item_Name=$row['Name'];            
						 }
             if ($kol>0){
        $kol=$kol-$quantity;
        $res = mysqli_query($link_mto, "UPDATE `Empl_hand-out` set quantity='$kol' where Emp_id='$name_id' and id_item='$Item_id' and id_size='$size_id'");                   
        $res = mysqli_query($link_mto, "Insert into `Empl-Returned` values (DEFAULT, '$name_id', '$Item_id', '$size_id', '$date', '$quantity', '$wearout'); ");
        $res = mysqli_query($link_mto, "select SName from Employee where ID='$name_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $SName=$row['SName'];
               $_SESSION['SName'] = $SName;            
						 }
             $res = mysqli_query($link_mto, "select Name from Item where ID='$Item_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $Item_Name=$row['Name'];              
               
						 }
             $res = mysqli_query($link_mto, "select size, height from Size where ID='$size_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $size=$row['size'];
               $height=$row['height'];
               $_SESSION['size']=$size;
               $_SESSION['height']=$height;            
						 }
if (!isset ($_SESSION['Item_id_1']))  {$_SESSION['Item_id_1'] = $Item_Name; $_SESSION['quantity_1']=$quantity; $_SESSION['prociznosa1']=$wearout; }
             elseif  (!isset ($_SESSION['Item_id_2'])) {$_SESSION['Item_id_2'] = $Item_Name; $_SESSION['quantity_2']=$quantity; $_SESSION['prociznosa2']=$wearout;}
             else {$_SESSION['Item_id_3'] = $Item_Name; $_SESSION['quantity_3']=$quantity; $_SESSION['prociznosa3']=$wearout;} 
              echo "<h2 style=\"color:green;\">Успешно принято от $SName, $Item_Name, размер:$size $height, количество:$quantity, $date, $wearout </h2>";   }  
           else { echo "<h2 style=\"color:red;\">За сотрудником $SName не числиться $Item_Name</h2>";}  }  }
      
            
function income($Item_id, $quantity){       // На склад
global $Item_id_1, $quantity_1, $size_id, $date, $link_mto, $Newsize_id;
 if ($Item_id!='10' xor     $Item_id!='11' xor   $Item_id!='12') {
           if ( $Item_id<5) {$size_id=$Newsize_id;} 
            else { $size_id=0; }
            $res =  mysqli_query($link_mto, "Insert into Income values (DEFAULT, '$Item_id', '$size_id', '$date', '$quantity'); ");
              
             $res1 =  mysqli_query($link_mto, "Select quantity from Warehouse where id_item='$Item_id' and id_size='$size_id'; ");
               if (mysqli_num_rows($res1)==0) {  
              $res =  mysqli_query($link_mto, "Insert into Warehouse values (DEFAULT, '$Item_id', '$size_id', '$quantity'); ");
                                             }
               else { 
               $res1 =  mysqli_query($link_mto, "Select quantity from Warehouse where id_item='$Item_id' and id_size='$size_id'; ");                            
                while ($row = mysqli_fetch_array($res1, MYSQLI_ASSOC))
					   {
						   $kol=$row['quantity'];            
						 }
             $quantity1=$kol+$quantity;
                    
              $res =  mysqli_query($link_mto, "UPDATE Warehouse set Warehouse.quantity='$quantity1' where Warehouse.id_item='$Item_id' and Warehouse.id_size='$size_id'; ");    
                    }
            
           if  ($res == 'true') {
          
             $res =  mysqli_query($link_mto, "select Name from Item where ID='$Item_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $Item_Name=$row['Name'];            
						 }
             $res =  mysqli_query($link_mto, "select size, height from Size where ID='$size_id'");  
                                         while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC))
					   {
						   $size=$row['size'];
               $height=$row['height'];            
						 }
             
            echo "<h2 style=\"color:green;\">Успешно Добавленно на склад $Item_Name, размер:$size $height, количество:$quantity, $date </h2>";   }  
           else { echo "<h2 style=\"color:red;\">Произошла ошибка при добавлении</h2>";}  
                                        }  
                                    }                                                                      
    
if (@$_POST['give']) {                   // Выдача сотруднику
  if (empty($Item_id_1 or $Item_id_2 or $Item_id_3))   {echo "<h2 style=\"color:red;\">Не выбрано Наименование выдача</h2>"; exit;}
if ( ($Item_id_1<5 and $size_id=='') or ($Item_id_2<5 and $size_id=='') or  ($Item_id_3<5  and $size_id=='')) {echo "<h2 style=\"color:red;\">Не выбран размер</h2>"; exit;} 	           
           give($Item_id_1, $quantity_1);
           give($Item_id_2, $quantity_2);
           give($Item_id_3, $quantity_3);
           $_SESSION['date'] = $date1;
        
                  
        echo $_SESSION['NoKol1'];
         echo $_SESSION['NoKol2'];
         echo $_SESSION['NoKol3'];
         unset($_SESSION['NoKol1']);
         unset($_SESSION['NoKol2']);
         unset($_SESSION['NoKol3']);
         
   if(isset($_SESSION['SName'])) {            
          
      
  # unset($_SESSION['netnasklade']);
   exit;              
                   } }  
                      
if (@$_POST['priem']) {

if ( ($Item_id_1<5 and $size_id=='') or ($Item_id_2<5 and $size_id=='') or  ($Item_id_3<5  and $size_id=='')) {echo "<h2 style=\"color:red;\">Не выбран размер</h2>"; exit;} 	  
           priem($Item_id_1, $quantity_1, $wearout1);
           priem($Item_id_2, $quantity_2, $wearout2);
           priem($Item_id_3, $quantity_3, $wearout3);
           $_SESSION['date'] = $date1;
        
      if(isset($_SESSION['SName'])) {           
     ?>  
   <meta http-equiv="refresh" content="0; url=Examples/MTO_priem_EX.php">
  <?php  exit;             
 }   } 
 
if (@$_POST['nasklad']) {          // На склад
 # if (empty($Item_id_1 or $Item_id_2 or $Item_id_3))   {echo "<h2 style=\"color:red;\">Не выбрано Наименование</h2>"; exit;}
if (($Item_id_1<5 and $size_id=='' ) or ($Item_id_2<5 and $size_id=='' ) or ($Item_id_3<5  and $size_id=='')) {echo "<h2 style=\"color:red;\">Не выбран размер</h2>"; exit;} 	   
          
           income($Item_id_1, $quantity_1);
           income($Item_id_2, $quantity_2);
           income($Item_id_3, $quantity_3);        
                                                          
                         }
                   
if (@$_POST['nabalanse']) {  
     ?>  
   <meta http-equiv="refresh" content="0; url=Examples/MTO_nabalanse_EX.php">
  <?php  exit;    
                      
                          } 

if (@$_POST['sklad']) {

     ?>  
   <meta http-equiv="refresh" content="0; url=Examples/MTO_na_sklade_EX.php">
  <?php  exit;    
                        
                      }                                                                       

if (@$_POST['giveEX']) {
$_SESSION['date'] = $date1;
 ?>   
   <meta http-equiv="refresh" content="0; url=Examples/MTO_vidacha_EX.php">
  <?php }  	
?>
</body>
</html>