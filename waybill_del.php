<html>    <title>�������� � ���������</title>
<head>  <link rel="shortcut icon" href="dimex.jpg" type="image/x-icon">  
<meta http-equiv="content-type" content="text/html; charset=cp1251">
 <link rel="stylesheet" href="stylestreet.css"  type="text/css">
 <style type="text/css">
   table {
          margin: auto; /* ����������� ������� �� ������ ����  */
      border-collapse: collapse;
   }
     
 .my_button {
    width: 190px;
    height: 30px;
border-radius: 5px; box-shadow: 1px 1px 2px; font-size: 15px
}
.my_button1 {
    width: 380px;
    height: 40px;
border-radius: 10px; box-shadow: 0px 0px 5px; font-size: 16px
}
 </style>
 </head>
<body>
 <br/>  
<form method="POST" action="">
  <input <button style="background: #00FF80; width: 70px; height: 40px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit" value="�����" name="but"></button></form><form action="Menu.php">
    <button style="background: #D8D8D8; width: 90px; height: 35px; 
border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 17px; text-align: center;" type="submit">�����</button>
</form> 
  <h3><div align="center" >���������� �� �������� � �������������� ���������</div></h3>
<?php
session_start(); //��������� ������ 
 $FilePHP = $_SERVER['PHP_SELF'];
 $LogIP=$_SERVER['REMOTE_ADDR'];
 $Login = $_SESSION['login']; 
if (@$_POST['but'] == true){
unset($_SESSION['login']);
unset($_SESSION['waybill_del']);
header("Location: index.php");
}
if(!isset($_SESSION['login'])){
     header("Location: index.php");
     exit;                       }  
if(!isset($_SESSION['waybill_del'])){
     header("Location: Menu.php");
     exit;                    }  
 include 'profilaktika.php'; 
     include 'gsotldb.php';
      
  ?>  
<table border=2px>
  <form name="MyForm" method="post">     
 <td><label for="WaybillNum"><center><font size="4" color="black"><b>����� ���������:</b</font></label> 
                    <center><input type="text" name="WaybillNum" autofocus size="11" maxlength="10"></td>
</table>
 
<?php
echo "<br/>";
  echo "<center><font size='4' color='blue'>������� ����� ������ ���������� �����</font>"; 		
   echo "<br/>";
   echo "<center><font size='4' color='#DF7401'>���� ��������� ����������������� ������ 1 ����, ���������� � ���, ��� � ����� ��� ������ ����� �������!</font>"; 		
   echo "<br/>";
   echo "<br/>";
echo "<center><button type='submit' formaction='waybill_del.php' class='my_button'>����� ����������</button>"; 
       echo "</center>";   
echo "<br/>";

if ($_SERVER['REQUEST_METHOD'] == "POST")  {
 $waybill=$_POST['WaybillNum'];

if(!empty($waybill)) {     
           
 if (strlen($waybill) > 3) {
  $res =  mysqli_query($link, "select WayBillNum, SY_Void from d15_departures where d15_departures.WayBillNum = '$waybill';");  
                     while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) 
                {

                     $void= $row['SY_Void'];
                     $way_base=$row['WayBillNum'];
                }
        if ($waybill == $way_base &&  $void==0 ) { echo "<h3 style=\"color:red;\">��������� $waybill �� ������� � �� �������������</h3>"; exit;}
        
        elseif ($waybill <> $way_base )   

  //��������������                 
                            {
 
               $res =  mysqli_query($link,     "SELECT d15_departures.WayBillNum, b.Name, a.Name, hb_employee.SName, syEvents.LogText,
                                                log_edit.Created_Time			
                                                FROM d15_departures			
                                                left join log_edit on log_edit.FieldID=d15_departures.ID			
                                                left join hb_employee on log_edit.SY_MembID=hb_employee.ID			
                                                left join hbc_divisions a on d15_departures.ToDivID=a.ID			
                                                left join hbc_divisions b on d15_departures.FromDivID=b.ID			
                                                left join syEvents on log_edit.syConnUIN=syEvents.UIN			
                                                WHERE log_edit.lValues like '%::WayBillNum== $waybill%' and log_edit.TablID=15;");
                  $ruz_num=mysqli_num_rows($res);
                  
                # echo  $ruz_num;
                  
                   if   ($ruz_num==0 )  {echo "<h4 style=\"color:green;\">��������� $waybill �� �������������</h4>";}
                   else {
                            ?>  
                                         <table border="1">
                                      <tr>
                                          <th colspan="7">�������������� ���������</th>
                                      </tr>
                                        <tr>
                                          <td>������ � ���������</td>
                                          <td>����� � ���������</td>
                                          <td>�����������</td>
                                          <td>����������</td>
                                          <td>���� ��������������</td>
                                          <td>���</td>
                                          <td>IP</td>
                                       </tr>
                                     
                                 <?php
                            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                            $ipScan = substr($row[4],5);     
                              ?>     <tr>
                                            
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[0] ?></td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[2] ?> </td>
                                            <td><?php echo $row[5] ?></td>
                                            <td><?php echo $row[3] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>          
                                        </table>
                                                 
                                  <?php
                                                                }  
                                                     }
                                                        }
 else {                                             
       
           // ��������

               $res =  mysqli_query($link,   "SELECT b.Name, a.Name, hb_employee.SName, syEvents.LogText, log_edit.Created_Time			
                                              FROM d15_departures			
                                              left join log_edit on log_edit.FieldID=d15_departures.ID			
                                              left join hb_employee on log_edit.SY_MembID=hb_employee.ID			
                                              left join hbc_divisions a on d15_departures.ToDivID=a.ID			
                                              left join hbc_divisions b on d15_departures.FromDivID=b.ID			
                                              left join syEvents on log_edit.syConnUIN=syEvents.UIN			
                                              WHERE d15_departures.WayBillNum ='$waybill' and log_edit.TablID=15 and log_edit.lValues like '%::SY_Void==%';");
                                        
                   $ruz_num=mysqli_num_rows($res);
                   
                   if   ($ruz_num==0) {echo "<h4 style=\"color:green;\">��������� $waybill �� �������</h4>";}
                   else {
                            ?>  
                                         <table border="1">
                                      <tr>
                                          <th colspan="7">�������� ���������</th>
                                      </tr>
                                        <tr>
                                        <td>����� ���������</td>
                                          <td>�����������</td>
                                          <td>����������</td>
                                          <td>���� ��������</td>
                                          <td>���</td>
                                          <td>IP</td>
                                       </tr>
                                     
                                 <?php
                                       
                          while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) 
                {          $ipScan = substr($row[3],5);     
                              ?>     <tr>
                                            
                                            <td><?php echo $waybill?> </td>
                                            <td><?php echo $row[0] ?></td>
                                            <td><?php echo $row[1] ?> </td>
                                            <td><?php echo $row[4] ?></td>
                                            <td><?php echo $row[2] ?></td>
                                            <td><?php echo $ipScan ?></td>
                                     </tr>       
                                      </table>  
                                             
                                 <?php       
                    
                                 } }  }  
                                    } else {echo "<h3 style=\"color:red;\">����� ��������� �� ����� ���� ������ 4 ��������</h3>";}
                                     }  
                                                   else {echo "<h3 style=\"color:red;\">������� ����� ���������.</h3>";} 
                                   }            
?>
 
</body>
</html>