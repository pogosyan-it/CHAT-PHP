<html>  <title>������ �� �����</title>
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
    width: 420px;
    height: 50px;
border-radius: 55px; box-shadow: 1px 1px 3px; font-size: 15px
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
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="�����" name="but"></button></form> 
        <br/>  
<form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">�����</button>
</form> 
   <h3><div align="center" >������ �� �����</div></h3>
<?php
session_start(); //��������� ������ 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['Zone']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['Zone'])){
     header("Location: Menu.php");
     exit;                    }  
   
 include 'gsotldb.php';
if (!@($_POST['run']))
  {
?>    
<center><br/>
 <p><font size="5">�������� ��������</font></p>
 
  <script type="text/javascript" src="tcal.js"></script> 
 <form action="Zone.php" method="post"></center>
 
   
       �<div><input type="text" name="date_from" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="�������� ��������� ����" /></div>
                                        
           <br/>
       ��<div><input type="text" name="date_by" readonly onfocus="this.removeAttribute('readonly')" size="24" class="tcal" value="�������� �������� ����" /></div>
       <br/>
          
  <br/><br/><br/><br/><br/><input type="submit" name="run" value='�������� ����' class="my_button">
  </form>
<?php
}
else
{ 
$n = $_POST['date_from'];
$k = $_POST['date_by'];
if ($n > $k)
  {
  echo "<h2 style=\"color:red;\">����������� ������� ����</h2>";
  exit;
  } 
  
  /*Action */     
     $result =  mysqli_query($link, "update d20_extask left join d15_departures on d20_extask.dXXID=d15_departures.ID 
                set d20_extask.ZoneID = d15_departures.FromZone 
                where d20_extask.typeKey=1 and d20_extask.ExTimeStamp BETWEEN '$n' and '$k' 
                and d20_extask.ZoneID <> d15_departures.FromZone");
     $result =  mysqli_query($link, "update d20_extask left join d15_departures on d20_extask.dXXID=d15_departures.ID
                set d20_extask.ZoneID = d15_departures.ToZone
                where d20_extask.typeKey=4 and d20_extask.ExTimeStamp BETWEEN '$n' and '$k'
                and d20_extask.ZoneID <> d15_departures.ToZone;");  
                                
    
     
    if  ($result == 'true') {
      $res =  mysqli_query($link, "Insert into PHP_Log VALUES(DEFAULT, '$FilePHP Action', '$Login', '$LogIP', NOW(),
                        'd20_extask.ZoneID=d15_departures.FromZone ::$n and $k ::d20_extask.ZoneID=d15_departures.ToZone ::$n and $k')");  
    echo "<h2 style=\"color:green;\"> �������� ������ ��� � $n �� $k </h2>"; 
        }
    else
    {
    echo "<h2 style=\"color:red;\">��������� ������ ��� ������� ���, ���������� � IT �����!</h2>";
    } 
    }                                               
  
 ?>
 <br/><br/><br/>   

</body>
</html>
