<html>    <title>�����������</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="style.css"  type="text/css">
 <style type="text/css">
   table {
    width: 440px; /* ������ ������� */
    margin: auto; /* ����������� ������� �� ������ ����  */
    border-collapse:separate;
border-spacing:10px 20px;
   }
     
 .my_button {
    width: 190px;
    height: 30px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}

 </style>
 </head>
<body>
<table align=center>  <tr><td>
 <span id="date" style="color:blue;">����</span>&nbsp;&nbsp;&nbsp;
 <span id="time" style="color:blue;">�����</span>
<script type="text/javascript">
function clock() {
var d = new Date();
var day = d.getDate();
var hours = d.getHours();
var minutes = d.getMinutes();
var seconds = d.getSeconds();

month=new Array("������", "�������", "�����", "������", "���", "����",
"����", "�������", "��������", "�������", "������", "�������");
days=new Array("�����������", "�����������", "�������", "�����",
"�������", "�������", "�������");

if (day <= 9) day = "0" + day;
if (hours <= 9) hours = "0" + hours;
if (minutes <= 9) minutes = "0" + minutes;
if (seconds <= 9) seconds = "0" + seconds;

date_date = day + " " + month[d.getMonth()] + " " + d.getFullYear() + " (" +
days[d.getDay()] + ")";
date_time = hours + ":" + minutes + ":" + seconds;

if (document.layers) {
 document.layers.date.document.write(date_time);
 document.layers.date.document.close();
 document.layers.time.document.write(date_time);
 document.layers.time.document.close();
}
else {
 document.getElementById("date").innerHTML = date_date;
 document.getElementById("time").innerHTML = date_time;
}
 setTimeout("clock()", 1000);
}
clock();
</script> 
</td> </tr> </table>  
<?php
 
include 'profilaktika.php'; 

session_start();
  ?>
  <br/><br/><br/><br/><br/>

<h3><div align="center" >����� � ������ ����� �� ��� � GSoT</div></h3>

 <?php
if (isset($_SESSION['NoLog'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">�� ������ �����</font></div>          
            <?php
  unset($_SESSION['NoLog']);   
 }
  else 
  {
  unset($_SESSION['NoLog']);
 }
 if (isset($_SESSION['NoPas'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">������� ������</font></div>          
            <?php
  unset($_SESSION['NoPas']);   
 }
  else 
  {
  unset($_SESSION['NoPas']);
 }

  if (isset($_SESSION['WrongPas'])) 
  { 
  ?>
<div id="error"><font size="6" color="red">�������� ������!</font></div>          
            <?php
  unset($_SESSION['WrongPas']);   
 }
  else 
  {
  unset($_SESSION['WrongPas']);
 }   
     
  if(isset($_SESSION['login'])){
     header("Location: Menu.php");
     exit;
 }
  include 'gsotldb.php';  
    ?>
      
        
    
    <form action="Menu.php" method="post">  
    <table  border=1px >
  
    
    <tr>
        
        <td   align="center"><font size="4">�����   <br/>
  <?php 
                      
  
   echo "<form method='post' action=''>
      <br/><select name='login'>
      <option value=''> �������� ������������</option>";     
	 
$res_pref =  mysqli_query($link, "Select hb_employee.Login from hb_employee where hb_employee.DepartamentID in ('2','6','9','14','15','18','19','20') 
                                  and hb_employee.SY_Void='0' and hb_employee.fUser='1' and hb_employee.SName not in ('DIMEX - �� ....', 'UK L.0.') or hb_employee.ID='23' or hb_employee.ID='3' order by Login;");                 
 
while ($row = mysqli_fetch_assoc($res_pref)){
   
echo "<option value='".$row['Login']."'>".$row['Login']." </option>";      
                                                 } 
   ?>
      </td>
      <td style="border-style:hidden" align="center"><font size="5">���
       </td>
      <td align="center"><font size="4">ID
        <p><input type="text" name="ID" readonly onfocus="this.removeAttribute('readonly')" autofocus size="5" maxlength="5"></p></td>
    </tr>
    
   
    <tr> <br/> 
       <td colspan="3" align="center"><font size="4">� ������:
       <p><input type="password" name="password" readonly onfocus="this.removeAttribute('readonly')" size="15" maxlength="15"></p></td>
        </tr>
</form></table>   
 
    <!--**** � ��������� ���� (name="login" type="text") ������������ ������ ���� ����� ***** -->

    <!--**** � ���� ��� ������� (name="password" type="password") ������������ ������ ���� ������ ***** --> 
    <br/>
   <center> <input type="submit" name="submit" value="�����" class='my_button'>
   
    <!--**** �������� (type="submit") ���������� ������ �� ��������� testreg.php ***** --> 
<br>
 
    <br>
   
</body>
</html>