<html><title>���������� �����</title>
<head>
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="style.css"  type="text/css">

 
 <style type="text/css">
 body 
 {margin:0 auto;  background:#F8F4B6;}
    * {margin: 0; padding: 0;} /* �������� ������� */
body {
text-align: center; /* ����������� ��� ���������� body �� ������ */
div {
width: 800px; /* ������ ��������� ����� */
height: 100%; /* ������ ��� ����������� */
margin: 0 auto; /* ������ ������ ����� � ������ auto ����� ��������� ������������ �� ������ */
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
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 18px; text-align: left;" type="submit">��������� �� ������� ��������</button>
<br/></form><br/><br/><br/> 


 <table style="text-align:center; width: 100%;">
    <tr>
       
        <td><p><font size="6">���������� ����� �� ���. ������������!!!</font></p></td>
    </tr>
    <tr>
        


</table>