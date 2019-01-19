 <meta http-equiv="content-type" content="text/html; charset=cp1251">
 <style type="text/css">

 .my_button2 {
    width: 190px;
    height: 30px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}
  </style>
  
  <?php  
   $time=date("Hi");
   if ( $time > '0000' && $time < '2359')  { echo "<br/><br/><h2 style=\"color:red;\">Сайт на Тех. обслуживании</h2>";
    ?>
    <br/><br/><input type="button" class="my_button2" onclick="document.location.reload()" value="Обновить" />
<?php   
   exit;
   }   
   ?>