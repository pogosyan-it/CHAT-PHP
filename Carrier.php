<html>  <title>Пересчёт тарифов поставщиков</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylephp.css"  type="text/css">
<link rel="stylesheet" href="tcal.css">        
 <style type="text/css">
 td
 {
 border: 1px #336699 solid;
 }
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

<br/>  
<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="Выход" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">Назад</button>
</form> 
   <h3><div align="center" >Перевозчик</div></h3>
<?php
session_start(); //Запускаем сессии 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['Carrier']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['Carrier'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'gsotldb.php';
  
  ?>
  <form method='post' action=''>   
  <select name='carrier'>
      <option value=''  disabled>Выберите перевозчика</option>";     
<?php	 
$res =  mysqli_query($link, "select distinct CarrierName from hb_carrier_tariffs");                 
 
while ($row = mysqli_fetch_assoc($res)){

echo "<option value='".$row['CarrierName']."'>".$row['CarrierName']." </option>";
                                                 } ?> 
                                               </select>
            <p><font size="4">интервал</font></p>
   	<script type="text/javascript" src="tcal.js"></script> 
    <form action="Carrier.php" method="post"> 
		с<div><input type="text" name="date_from" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите начальную дату" /></div><br/> 
    по<div><input type="text" name="date_by" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="выберите конечную дату" /></div>
      
  <br/><br/><br/><input type="submit" name="run" value='Пересчитать поставщиков' class="my_button">
  </form>
<?php
if (@($_POST['run']))
  {
   if($_POST['date_from']=='выберите начальную дату' or $_POST['date_by']=='выберите конечную дату')
   {echo "<h2 style=\"color:red;\">Не выбрана дата!</h2>";
  exit;}
$carrier = $_POST['carrier'];
$date_from = $_POST['date_from'].' 00:00:00';
$date_by = $_POST['date_by'].' 23:59:59';
 # echo  $date_from, $date_by;

  if ($date_from > $date_by)
  {
  echo "<h2 style=\"color:red;\">Некорректно выбран интервал</h2>";
  exit;
  }
 
  /*Action */   
     $result1 =  mysqli_query($link, "Truncate TMP_Table");  
     $result2 =  mysqli_query($link, "Insert into TMP_Table Select d50_vo.ID, SUM(d30_manifests.Sh_Weight) as WayBillWeight, SUM(d30_manifests.Sh_Weight) as Sh_Weight,
                                     SUM(d30_manifests.Sh_Weight) as WayBillSumm, hb_carrier_tariffs.Tariff
                                     from d50_vo

                                     left join d30_manifests on d50_vo.ID=d30_manifests.d50ID
                                     left join hbc_divisions on d50_vo.ToDiv=hbc_divisions.ID
                                     left join hb_carrier_tariffs on d50_vo.ToDiv=hb_carrier_tariffs.Divisions_ID and d50_vo.SendType=hb_carrier_tariffs.SendType_ID

                                     where hbc_divisions.ID in (Select distinct hb_carrier_tariffs.Divisions_ID from hb_carrier_tariffs) and d30_manifests.fClose=1 and d50_vo.lCargoHandedOver
                                     between '$date_from' and '$date_by' and d50_vo.SendType in ('2','4') 
                                     and d30_manifests.SY_Void=0 and d50_vo.Carrier=16
                                     GROUP BY d50_vo.ID"); 
    
      $result3 =  mysqli_query($link, "UPDATE d50_vo d50, TMP_Table TMP
                                     SET
                                     d50.WayBillSumm = CEILING(TMP.WayBillSumm)*TMP.Tarrifs*1.2,
                                     d50.Sh_Weight = TMP.Sh_Weight, d50.WayBillWeight = TMP.WayBillWeight
                                     WHERE d50.ID = TMP.ID");         
	if($result1==false or $result2==false or $result3==false)
	{
		echo "<h2 style=\"color:red;\">Произошла ошибка при выполнении!</h2>";
		exit();	
	} else  {
  $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                        'пересчёт $carrier с $date_from по $date_by')");  
  
      	echo "<h2 style=\"color:green;\">Успешный пересчёт $carrier с $date_from по $date_by</h2>";
      }     
    }                                               
  
 ?>
 <br/><br/><br/>   

</body>
</html>
