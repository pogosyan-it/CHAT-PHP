<html>    <title>Добавление адреса в справочник</title>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
 <style type="text/css">
   table {
    width: 550px; /* Ширина таблицы */
    margin: auto; /* Выравниваем таблицу по центру окна  */
   }
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
 </head>
<body>
<br/><br/>   
<form action="index.html">
    <button style="background: #F5ECCE; width: 360px; height: 50px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 18px; text-align: left;" type="submit">Вернуться на главную страницу</button>
 </form>

   
<?php  
    
 
    $link = mysqli_connect( 
            '10.10.1.2',  /* Хост, к которому мы подключаемся */ 
            'root',       /* Имя пользователя */ 
            '2me32jvppn',   /* Используемый пароль */ 
            'gsotldb');     /* База данных для запросов по умолчанию */ 
    #$link->set_charset("cp1251");
     $link->set_charset('utf8');  

?>  
    <form action="ARRAY.php" method="post">  
    <table>
    <tr>
        <td align="right">Регион Отправления:</td>
        <td><font size="6"><b>CORP</b></td>
    </tr>
    <tr>
        <td align="right">Регион Назначения:</td>
        <td></select>
  <?php 
    
   echo "<form method='post' action=''>
      <select name='dest'>
      <option value=''>Номера Накладных</option>";     
	  
      
$res_pref =  mysqli_query($link, "Select WayBillNum from d15_departures where d15_departures.WayBillDate > '2016-21-06 16:17:39';") ;                 
 
while ($row = mysqli_fetch_assoc($res_pref)){

$waybill=$row['WayBillNum'];
printf($waybill);
 
}  
 


   ?>
