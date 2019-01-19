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
   if ( $time > '1559' && $time < '1610')  { echo "<br/><br/><h2 align=\"center\" style=\"color:red;\">Сайт на профилактике до 16-10</h2>";
   
    ?>  </br> <form action= "Menu.php" method= "POST"><p align="center"><input  <button 
     type="submit" class="my_button2" value="Обновить"</button></form></p>
      
<?php   
   exit;
   }
    if ( $time > '0059' && $time < '0110')  { echo "<br/><br/><h2 align=\"center\" style=\"color:red;\">Сайт на профилактике до 01-10</h2>";
    ?>
   </br> <form action= "Menu.php" method= "POST"><p align="center"><input  <button 
     type="submit" class="my_button2" value="Обновить"</button></form></p>
<?php   
   exit;
   }   
   ?>