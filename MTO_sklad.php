<html>    <title>Склад МТО</title>
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
    width: 200px;
    height: 40px;
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
<form action="mto.php">
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

?>  
 <h3><div align="center" >Склад МТО</div></h3>
<form action="MTO_sklad.php" method="post">  
<table cellspacing="1" border="1">     
    <tr>
  
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
 <br/>
  </center>
            </td>
     </tr>
        <td>
       
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
   <td><center>  <label for="Day">Количество:</label>
        <select name="amount1">
<?php
       for ($j=1; $j<11; $j++) {echo "<option value='$j'>$j</option>";}
?>
      </select>
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
       <td><center>  <label for="Day">Количество:</label>
       <select name="amount2">
<?php
       for ($j=1; $j<11; $j++) {echo "<option value='$j'>$j</option>";}
?>
      </select> 
       </td>
 
    </tr>
    <tr>
        <td>
       
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
       <td><center><label for="Day">Количество:</label>
       <select name="amount3">
<?php
       for ($j=1; $j<11; $j++) {echo "<option value='$j'>$j</option>";}
?>
      </select> 
       </td>
 
    </tr>
    <tr>

       <td colspan="2" >
<center><br /> <input name="income" type="submit" value="Принять на склад" class="my_button">    
 <br /> </form> 
    </td>
    </tr>
</table>

<?php  
     
  $size_id=@$_POST['size'];
  $date=@$_POST['date'];
  $date=$date.date(" H:i:s"); 
  
  $Item_id_1=@$_POST['clothes1'];
  $Item_id_2=@$_POST['clothes2'];
  $Item_id_3=@$_POST['clothes3'];
  
  $quantity_1=@$_POST['amount1'];
  $quantity_2=@$_POST['amount2'];
  $quantity_3=@$_POST['amount3'];
#echo "name_id=$name_id, date=$date, size_id=$size_id, Item_id_1=$Item_id_1, Item_id_2=$Item_id_2,  Item_id_3=$Item_id_3, quantity_1=$quantity_1, quantity_2=$quantity_2, quantity_3=$quantity_3"; 

function income($Item_id, $quantity){
global $Item_id_1, $quantity_1, $size_id, $date, $link_mto;
 if (!empty ($Item_id)) {
      	     $res =  mysqli_query($link_mto, "Insert into Income values (DEFAULT, '$Item_id', '$size_id', '$date', '$quantity'); "); 
             $res1 =  mysqli_query($link_mto, "Select quantity from Warehouse where id_item='$Item_id' and id_size='$size_id'; ");
               if (mysqli_num_rows($res1)==0) {  
              $res =  mysqli_query($link_mto, "Insert into Warehouse values (DEFAULT, '$Item_id', '$size_id', '$quantity'); ");
                                             }
               else {                             
                while ($row = mysqli_fetch_array($res1, MYSQLI_ASSOC))
					   {
						   $kol=$row['quantity'];            
						 }
             $quantity=$kol+$quantity;
              $res =  mysqli_query($link_mto, "UPDATE Warehouse set Warehouse.quantity='$quantity' where Warehouse.id_item='$Item_id' and Warehouse.id_size='$size_id'; ");    
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
             
            echo "<h2 style=\"color:green;\">Успешно Добавленно на склад $Item_Name, размер $size $height, количество $quantity, $date </h2>";   }  
           else { echo "<h2 style=\"color:red;\">Произошла ошибка при добавлении</h2>";}  
                                        }  
                                    }
                              
if (@$_POST['income']) { 
  if (empty($Item_id_1 or $Item_id_2 or $Item_id_3))   {echo "<h2 style=\"color:red;\">Не выбрано Наименование</h2>"; exit;}
	    else {
          
           income($Item_id_1, $quantity_1);
           income($Item_id_2, $quantity_2);
           income($Item_id_3, $quantity_3);        
                                                             }
                         }
        
?>
</body>
</html>