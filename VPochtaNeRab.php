<html><title>Внутренняя почта</title>
<head>
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="style.css"  type="text/css">

 
 <style type="text/css">
 body 
 {margin:0 auto;  background:#F8F4B6;}
    * {margin: 0; padding: 0;} /* обнуляем отступы */
body {
text-align: center; /* выравниваем все содержимое body по центру */
div {
width: 800px; /* ширина основного блока */
height: 100%; /* высота для наглядности */
margin: 0 auto; /* задаем отступ слева и справа auto чтобы сработало выравнивание по центру */
}
 {
 border: 1px #336699 solid;
 }
 
 </style>
 
  <?php

include 'profilaktika.php'; 

 session_start();
   if(!isset($_SESSION['login'])){
     header("Location: createVP1.php");
     exit;
 }  ?>
<br/><br/><br/> <br/>
   <form action="index.php">
    <button style="background: #F5ECCE; width: 290px; height: 50px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 18px; text-align: left;" type="submit">Вернуться на главную страницу</button>
<br/></form><br/><br/><br/> 


 <table style="text-align:center; width: 100%;">
    <tr>
       
        <td><p><font size="6">Внутренняя почта на тех. обслуживании!!!</font></p></td>
    </tr>
    <tr>
        


</table>